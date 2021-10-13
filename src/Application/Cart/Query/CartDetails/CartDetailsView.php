<?php

namespace App\Application\Cart\Query\CartDetails;

final class CartDetailsView
{
    public int $totalCount;

    public float $totalCost;

    /** @var CartDetailsProductView[] $products */
    public array $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
        $this->totalCount = count($products);

        $totalCost = 0;
        foreach ($products as $product) {
            $totalCost += $product->getPriceInt() * $product->quantity;
        }

        $this->totalCost = round($totalCost/100, 2);
    }
}
