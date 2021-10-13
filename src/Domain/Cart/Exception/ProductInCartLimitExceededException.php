<?php

namespace App\Domain\Cart\Exception;

use DomainException;

final class ProductInCartLimitExceededException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Product quantity limit exceeded.');
    }
}
