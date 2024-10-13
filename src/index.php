<?php
require  __DIR__ '/vendor/autoload.php';
use ScrapeHelper\Scraper;

$scraper = new Scraper('https://www.magpiehq.com/');
$products = $scraper->scrape('developer-challenge/smartphones');

// Save products to JSON file
file_put_contents('output.json', json_encode($products, JSON_PRETTY_PRINT));

?>