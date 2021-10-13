<?php

namespace App\Domain\Product\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProductNotFoundException extends NotFoundHttpException
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('Product with id #%d not found.', $id));
    }
}
