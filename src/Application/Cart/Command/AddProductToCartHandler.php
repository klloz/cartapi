<?php

namespace App\Application\Cart\Command;

use App\Domain\Cart\CartProduct;
use App\Domain\Cart\CartProducts;
use App\Domain\Cart\Carts;
use App\Domain\Cart\Exception\CartCapacityExceededException;
use App\Domain\Cart\Exception\CartNotFoundException;
use App\Domain\Cart\Exception\ProductInCartLimitExceededException;
use App\Domain\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Products;
use Ramsey\Uuid\Rfc4122\UuidV4;

final class AddProductToCartHandler
{
    const CART_CAPACITY = 3;
    const PRODUCT_QUANTITY_LIMIT = 10;

    private Carts $carts;
    private Products $products;
    private CartProducts $cartProducts;

    public function __construct(Carts $carts, Products $products, CartProducts $cartProducts)
    {
        $this->carts = $carts;
        $this->products = $products;
        $this->cartProducts = $cartProducts;
    }

    public function handle(AddProductToCartCommand $command): void
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
        if ($cartProduct) {
            if ($cartProduct->getQuantity() >= self::PRODUCT_QUANTITY_LIMIT) {
                throw new ProductInCartLimitExceededException();
            }

            $cartProduct->increaseQuantity();

            return;
        }

        if ($cart->getProductsCount() >= self::CART_CAPACITY) {
            throw new CartCapacityExceededException();
        }

        $cartProduct = new CartProduct(UuidV4::uuid4(), $product);
        $cart->addCartProduct($cartProduct);
    }
}
