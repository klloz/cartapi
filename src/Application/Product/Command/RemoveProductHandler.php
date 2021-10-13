<?php

namespace App\Application\Product\Command;

use App\Domain\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Product;
use App\Domain\Product\Products;

final class RemoveProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function handle(RemoveProductCommand $command): void
    {
        /** @var Product $product */
        $product = $this->products->findById($command->id);

        if ($product === null) {
            throw new ProductNotFoundException($command->id);
        }

        $this->products->remove($product);
    }
}
