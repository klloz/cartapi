<?php

namespace App\Domain\Cart\Exception;

use DomainException;

final class CartCapacityExceededException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Cart capacity has been exceeded.');
    }
}
