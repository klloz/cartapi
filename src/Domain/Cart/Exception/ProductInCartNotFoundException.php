<?php

namespace App\Domain\Cart\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProductInCartNotFoundException extends NotFoundHttpException
{
    public function __construct(int $cartId, int $productId)
    {
        parent::__construct(sprintf('Product with id #%d not found in cart with id #%d.', $productId, $cartId));
    }
}
