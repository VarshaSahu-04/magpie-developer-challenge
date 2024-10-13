<?php

namespace App;

require_once 'HttpClient.php';
require_once 'ProductExtractor.php';

class ScrapeHelper
{
    private HttpClient $client;
    private ProductExtractor $extractor;

    public function __construct(string $baseUri)
    {
        $this->client = new HttpClient($baseUri);
        $this->extractor = new ProductExtractor();
    }   

    public function scrapeHelper(string $endpoint): array
    {
        
        $products = [];
        $page = 1;

        try {
            do {
                $html = $this->client->fetchPage($endpoint, $page); // fetch HTML element based on pagination
                $products = array_merge($products, $this->extractor->extractProducts($html));
                $page++;
            } while ($this->extractor->hasNextPage($html));
        } catch (\Exception $e) {           
            error_log("Error during scraping: " . $e->getMessage());            
            return $products; // Return whatever products were successfully scraped
        }

        return $this->extractor->extractArray($products); // Convert Object into Array
    }
}
