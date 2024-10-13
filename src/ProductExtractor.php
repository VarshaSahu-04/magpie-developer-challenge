<?php
namespace App;

use Symfony\Component\DomCrawler\Crawler;
use Exception;

class ProductExtractor
{
    private string $baseUrl = 'https://www.magpiehq.com/developer-challenge';
    private array $uniqueProducts = [];

    public function extractProducts(string $html): array
    {
        $products = [];

        try {
            $crawler = new Crawler($html);
           
            $crawler->filter('.product')->each(function (Crawler $node) use (&$products) {
                try {
                    //extract product details like title, price, capacity, color, imageurl.
                    $extractedProducts = $this->extractProductData($node);
                    foreach ($extractedProducts as $product) {
                        $uniqueKey = $product->getTitle() . '|' . $product->getPrice() . '|' . $product->getCapacityMB() . '|' . $product->getColour();
                        
                        // Check for uniqueness. De-duplication check.
                        if (!isset($this->uniqueProducts[$uniqueKey])) {
                            $this->uniqueProducts[$uniqueKey] = true; 
                            $products[] = $product; 
                        }
                    }
                } catch (Exception $e) {
                    // Log or handle the specific product extraction error
                    error_log("Error extracting product data: " . $e->getMessage());
                }
            });
        } catch (Exception $e) {
            // Log or handle the general HTML parsing error
            error_log("Error parsing HTML: " . $e->getMessage());
        }

        return $products;
        
    }

    private function extractProductData(Crawler $node): array
    {
        try {
            $title = $node->filter('span.product-name')->text();
            $price = $this->extractPrice($node->filter('.text-lg')->text());
            $imageUrl = $this->extractImageUrl($node);
            $capacityMB = $this->extractCapacity($node->filter('.product-capacity')->text());

            $colours = $node->filter('span[data-colour]')->each(fn(Crawler $colourNode) => $colourNode->attr('data-colour'));

            $availabilityText = trim(str_replace('Availability: ', '', $node->filter('.my-4.text-sm')->text()));
            $isAvailable = stripos($availabilityText, 'Out of Stock') === false;
            $shippingDetails = $this->extractShippingDetails($node);

            return array_map(fn($colour) => new Product(
                $title,
                $price,
                $imageUrl,
                $capacityMB,
                $colour,
                $availabilityText,
                $isAvailable,
                $shippingDetails['shippingText'],
                $shippingDetails['shippingDate']
            ), $colours);
        } catch (Exception $e) {
            // Log or handle the error in extracting product data
            error_log("Error extracting product data from node: " . $e->getMessage());
            return []; // Return an empty array on error
        }
    }

    private function extractPrice(string $priceText): float
    {
        return floatval(str_replace('£', '', $priceText));
    }

    private function extractCapacity(string $capacityText): int
    {
       return (int)str_replace(' GB', '', $capacityText) * 1024; // Convert GB to MB
    }

    private function extractShippingDetails(Crawler $node): array
    {
        $shippingText = $node->filter('.my-4.text-sm.block.text-center')->count() > 1 ? 
            $node->filter('.my-4.text-sm.block.text-center')->eq(1)->text() : '';

        return [
            'shippingText' => $shippingText,
            'shippingDate' => $this->parseShippingDate($shippingText),
        ];
    }

    private function extractImageUrl(Crawler $node): string
    {
        $imagePath = $node->filter('img')->attr('src');
        $fullPath = rtrim($this->baseUrl, '/') . ltrim($imagePath, '/');

        return str_replace("..", "", $fullPath);
    }

    private function parseShippingDate(string $shippingText): ?string
    {
        $pattern = '/\b(?:Delivery by|Delivered from|Available on|Delivers|Free Delivery|Free Shipping)?\s*(?:(?:Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday)\s+)?(\d{1,2})(?:st|nd|rd|th)?\s+(\w+)\s+(\d{4})|\b(\d{4}-\d{2}-\d{2})\b/i';

        if (preg_match($pattern, $shippingText, $matches)) {
            if (!empty($matches[1])) { // Day-Month-Year format
                return \DateTime::createFromFormat('d M Y', sprintf('%s %s %s', $matches[1], $matches[2], $matches[3]))?->format('Y-m-d');
            }
            if (!empty($matches[4])) { // YYYY-MM-DD format
                return \DateTime::createFromFormat('Y-m-d', $matches[4])?->format('Y-m-d');
            }
        }

        return null;
    }

    public function hasNextPage(string $html): bool
    {
        $crawler = new Crawler($html);
        return $crawler->filter('#pages a.active')->nextAll('a')->first()->count() > 0;
    }

    public function extractArray(array $products): array
    {
        return array_map(fn($product) => $product->toArray(), $products);
    }
}
