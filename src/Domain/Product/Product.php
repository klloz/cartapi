<?php

namespace App\Domain\Product;

use Ramsey\Uuid\UuidInterface;

class Product
{
    private int $id;
    private UuidInterface $uuid;
    private string $title;
    private int $price;
    private Currency $currency;

    public function __construct(UuidInterface $uuid, string $title, int $price, Currency $currency)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}
