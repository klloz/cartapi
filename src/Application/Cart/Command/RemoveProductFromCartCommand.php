<?php

namespace App\Application\Cart\Command;

final class RemoveProductFromCartCommand
{
    /**
     * @Assert\NotBlank()
     */
    public ?int $cartId;

    /**
     * @Assert\NotBlank()
     */
    public ?int $productId;

    public function __construct(?int $cartId = null, ?int $productId = null)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
    }

}
