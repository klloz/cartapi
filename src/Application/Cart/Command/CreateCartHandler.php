<?php

namespace App\Application\Cart\Command;

use App\Domain\Cart\Cart;
use App\Domain\Cart\Carts;

final class CreateCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    public function handle(CreateCartCommand $command): void
    {
        $cart = new Cart($command->uuid);

        $this->carts->add($cart);
    }
}
