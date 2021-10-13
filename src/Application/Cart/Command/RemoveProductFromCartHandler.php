<?php

namespace App\Application\Cart\Command;

use App\Domain\Cart\CartProducts;
use App\Domain\Cart\Carts;
use App\Domain\Cart\Exception\CartNotFoundException;
use App\Domain\Cart\Exception\ProductInCartNotFoundException;
use App\Domain\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Products;

final class RemoveProductFromCartHandler
{
    private Carts $carts;
    private Products $products;
    private CartProducts $cartProducts;

    public function __construct(Carts $carts, Products $products, CartProducts $cartProducts)
    {
        $this->carts = $carts;
        $this->products = $products;
        $this->cartProducts = $cartProducts;
    }

    public function handle(RemoveProductFromCartCommand $command): void
    {
        $cart = $this->carts->findById($command->cartId);
        if (!$cart) {
            throw new CartNotFoundException($command->cartId);
        }

        $product = $this->products->findById($command->productId);
        if (!$product) {
            throw new ProductNotFoundException($command->productId);
        }

        $cartProduct = $this->cartProducts->findProductInCart($product, $cart);
        if (!$cartProduct) {
            throw new ProductInCartNotFoundException($command->cartId, $command->productId);
        }

        if ($cartProduct->getQuantity() > 1) {
            $cartProduct->decreaseQuantity();

            return;
        }

        $cart->removeCartProduct($cartProduct);
    }
}
