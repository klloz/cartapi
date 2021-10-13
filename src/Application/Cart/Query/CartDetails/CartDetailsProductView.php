<?php

namespace App\Application\Cart\Query\CartDetails;

final class CartDetailsProductView
{
    public int $id;
    public string $title;
    public float $price;
    public string $currency;
    public int $quantity;
    private int $priceInt;

    public function __construct(int $id, string $title, int $price, string $currency, int $quantity)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = round($price/100, 2);
        $this->currency = $currency;
        $this->quantity = $quantity;
        $this->priceInt = $price;
    }

    public function getPriceInt(): int
    {
        return $this->priceInt;
    }
}
