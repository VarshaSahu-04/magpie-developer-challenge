<?php

namespace App;

class Product
{
    private string $title;
    private float $price;
    private string $imageUrl;
    private int $capacityMB; // Capacity in MB
    private string $colour;
    private string $availabilityText;
    private bool $isAvailable;
    private string $shippingText;
    private ?string $shippingDate; // Nullable if not applicable

    public function __construct(string $title, float $price, string $imageUrl, int $capacityMB, string $colour, string $availabilityText,
        bool $isAvailable, string $shippingText, ?string $shippingDate) {
        $this->title = $title;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->capacityMB = $capacityMB;
        $this->colour = $colour;
        $this->availabilityText = $availabilityText;
        $this->isAvailable = $isAvailable;
        $this->shippingText = $shippingText;
        $this->shippingDate = $shippingDate;
    }

    // Getters for the properties
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getCapacityMB(): int
    {
        return $this->capacityMB;
    }

    public function getColour(): string
    {
        return $this->colour;
    }

    public function getAvailabilityText(): string
    {
        return $this->availabilityText;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function getShippingText(): string
    {
        return $this->shippingText;
    }

    public function getShippingDate(): ?string
    {
        return $this->shippingDate;
    }

    // Convert product data to an associative array
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'imageUrl' => $this->imageUrl,
            'capacityMB' => $this->capacityMB,
            'colour' => $this->colour,
            'availabilityText' => $this->availabilityText,
            'isAvailable' => $this->isAvailable,
            'shippingText' => $this->shippingText,
            'shippingDate' => $this->shippingDate,
        ];
    }

    // String representation for debugging
    public function __toString(): string
    {
        return sprintf(
            "Product: %s\nPrice: %.2f\nCapacity: %dMB\nColour: %s\nAvailability: %s\nAvailable: %s\nShipping: %s\nShipping Date: %s",
            $this->title,
            $this->price,
            $this->capacityMB,
            $this->colour,
            $this->availabilityText,
            $this->isAvailable ? 'Yes' : 'No',
            $this->shippingText,
            $this->shippingDate ?? 'N/A' // Display 'N/A' if shipping date is null
        );
    }
}
