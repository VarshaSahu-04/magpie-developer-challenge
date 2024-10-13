## Magpie PHP Developer Challenge

I gathered data about the products listed on https://www.magpiehq.com/developer-challenge/smartphones

The final output of my script is an array of objects similar to the example below:

```
{
    "title": "iPhone 11 Pro 64GB",
    "price": 123.45,
    "imageUrl": "https://example.com/image.png",
    "capacityMB": 64000,
    "colour": "red",
    "availabilityText": "In Stock",
    "isAvailable": true,
    "shippingText": "Delivered from 25th March",
    "shippingDate": "2021-03-25"
}

```

I have used same repository given by client as a starter template.

Result is created in `output.json`.

### Notes as per bellow instaructions
* De-duplication: Ensured that the client does not see the same product multiple times, even if it’s listed more than once on the website. Products are differentiated by title, price, color, and capacity.
* Variant Capture: All product variants are captured, with each color variant treated as a separate product.
* Capacity in MB: Device capacity is recorded in megabytes (MB) for all products.
* Pagination: The scraper handles pagination to capture all product pages.
* Testing: Utilized PHPUnit to run test cases, ensuring the reliability of the code



### Requirements

* PHP 7.4+
* Composer

### Setup

```
git clone https://github.com/VarshaSahu-04/magpie-developer-challenge.git
cd magpie-developer-challenge
composer install
```

To run the scrape you can use `php src/Scrape.php`

### Output

The final results will be saved in output.json located in the project root.
