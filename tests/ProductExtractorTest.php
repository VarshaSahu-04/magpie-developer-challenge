<?php
use PHPUnit\Framework\TestCase;
use App\ProductExtractor;

class ProductExtractorTest extends TestCase
{
    public function testExtractProducts()
    {
        $html = '<div class="product px-4 w-full md:w-1/2 mx-auto max-w-md mb-12">
                    <div class="bg-white p-4 rounded-md">
                        <h3 class="text-blue-600 my-4 text-xl block text-center">
                            <span class="product-name">Galaxy 12 Pro</span>
                            <span class="product-capacity">64 GB</span>
                        </h3>
                        <img src="../images/iphone-11-pro.png" style="max-width: 150px;" class="my-8 mx-auto">
                        <div class="my-4">
                            <div class="flex flex-wrap justify-center -mx-2">
                                <div class="px-2">
                                    <span data-colour="Green" class="border border-black rounded-full block" style="width: 20px; height: 20px; background-color: Green">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="my-8 block text-center text-lg">
                            £799.99
                        </div>
                        <div class="my-4 text-sm block text-center">
                            Availability: Out of Stock
                        </div>
                    </div>
                </div>';

        $extractor = new ProductExtractor();
        $products = $extractor->extractProducts($html);      

        $this->assertCount(1, $products);
        $this->assertEquals('Galaxy 12 Pro', $products[0]->getTitle()); // Update to correct product title
        $this->assertEquals(799.99, $products[0]->getPrice()); // Update expected price
        $this->assertEquals(65536, $products[0]->getCapacityMB()); // This remains the same if capacity is still correct
    }
}
