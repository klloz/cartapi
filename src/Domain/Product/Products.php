<?php

namespace App\Domain\Product;

interface Products
{
    public function findById(int $id): ?Product;

    public function findByTitle(string $title): ?Product;

    public function add(Product $product): void;

    public function remove(Product $product): void;
}
