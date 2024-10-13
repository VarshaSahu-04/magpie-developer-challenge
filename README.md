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

I have used same repository goven by client as a starter template.

Result is created in `output.json`.

### Notes as per bellow instaructions
* I have de-dupe data. Client will not see the same product twice, even if it’s listed twice on the website. Product is diffrentiated by title,price,color,capacity.  
* All product variants are captured. Each colour variant is treated as a separate product.
* Device capacity is captured in MB for all products (not GB)
* The final output is an array of products, outputted to `output.json`
* Pagination is also considered!


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
