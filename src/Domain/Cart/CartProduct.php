<?php

namespace App\Domain\Cart;

use App\Domain\Product\Product;
use Ramsey\Uuid\UuidInterface;

class CartProduct
{
    private int $id;
    private UuidInterface $uuid;
    private Product $product;
    private Cart $cart;
    private int $quantity;

    public function __construct(UuidInterface $uuid, Product $product)
    {
        $this->uuid = $uuid;
        $this->product = $product;
        $this->quantity = 1;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    public function decreaseQuantity(): void
    {
        $this->quantity--;
    }
}
