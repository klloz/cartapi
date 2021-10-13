<?php

namespace App\Application\Product\Command;

use App\Domain\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Exception\ProductTitleAlreadyInUseException;
use App\Domain\Product\Products;

final class EditProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function handle(EditProductCommand $command): void
    {
        $product = $this->products->findById($command->id);

        if (!$product) {
            throw new ProductNotFoundException($command->id);
        }

        $title = trim($command->title);
        $productByTitle = $this->products->findByTitle($title);

        if ($productByTitle && $productByTitle !== $product) {
            throw new ProductTitleAlreadyInUseException($title);
        }

        $product->setTitle($title);
        $product->setPrice($command->price);
    }
}
