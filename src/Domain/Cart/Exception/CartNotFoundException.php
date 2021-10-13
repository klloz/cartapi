<?php

namespace App\Domain\Cart\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CartNotFoundException extends NotFoundHttpException
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('Cart with id #%d not found.', $id));
    }
}
