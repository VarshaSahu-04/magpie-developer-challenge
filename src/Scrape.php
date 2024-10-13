<?php

require 'vendor/autoload.php';

use App\ScrapeHelper;

class Scrape
{
    private array $products = [];

    public function run(): void
    {
        
        try {
            $scraper = new ScrapeHelper('https://www.magpiehq.com/');
            $products = $scraper->scrapeHelper('developer-challenge/smartphones');  

            // Save products to JSON file
            file_put_contents('output.json', json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        } catch (\Exception $e) {            
            error_log("Error during scraping: " . $e->getMessage());
           
        }
    }
}

$scrape = new Scrape();
$scrape->run();
