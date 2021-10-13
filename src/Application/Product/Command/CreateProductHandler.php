<?php

namespace App\Application\Product\Command;

use App\Domain\Product\Currencies;
use App\Domain\Product\Exception\CurrencyNotFoundException;
use App\Domain\Product\Exception\ProductTitleAlreadyInUseException;
use App\Domain\Product\Product;
use App\Domain\Product\Products;

final class CreateProductHandler
{
    private Products $products;
    private Currencies $currencies;

    public function __construct(Products $products, Currencies $currencies)
    {
        $this->products = $products;
        $this->currencies = $currencies;
    }

    public function handle(CreateProductCommand $command): void
    {
        $title = trim($command->title);

        if ($this->products->findByTitle($title)) {
            throw new ProductTitleAlreadyInUseException($title);
        }

        $currency = $this->currencies->findById($command->currencyId);
        if (!$currency) {
            throw new CurrencyNotFoundException($command->currencyId);
        }

        $product = new Product(
            $command->uuid,
            $title,
            $command->price,
            $currency
        );

        $this->products->add($product);
    }
}
