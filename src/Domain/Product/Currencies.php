<?php

namespace App\Domain\Product;

interface Currencies
{
    public function findById(int $id): ?Currency;

    public function getFormList(): array;
}
