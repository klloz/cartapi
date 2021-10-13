<?php

namespace App\Domain\Cart;

use App\Domain\Product\Product;

interface CartProducts
{
    public function findProductInCart(Product $product, Cart $cart): ?CartProduct;
}
