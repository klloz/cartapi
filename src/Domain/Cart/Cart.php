<?php

namespace App\Domain\Cart;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Cart
{
    private int $id;
    private UuidInterface $uuid;
    private Collection $cartProducts;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductsCount(): int
    {
        return $this->cartProducts->count();
    }

    public function addCartProduct(CartProduct $cartProduct): void
    {
        $cartProduct->setCart($this);
        $this->cartProducts->add($cartProduct);
    }

    public function removeCartProduct(CartProduct $cartProduct): void
    {
        $this->cartProducts->removeElement($cartProduct);
    }
}
