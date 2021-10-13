<?php

namespace App\Application\Product\Query\ProductList;

final class ProductListItemView
{
    public int $id;
    public string $title;
    public float $price;
    public string $currency;

    public function __construct(int $id, string $title, int $price, string $currency)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = round($price/100, 2);
        $this->currency = $currency;
    }
}
