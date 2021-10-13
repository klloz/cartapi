<?php

namespace App\Domain\Cart;

interface Carts
{
    public function findById(int $id): ?Cart;

    public function add(Cart $cart): void;

    public function remove(Cart $cart): void;
}
