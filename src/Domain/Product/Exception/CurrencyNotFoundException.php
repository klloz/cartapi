<?php

namespace App\Domain\Product\Exception;

use InvalidArgumentException;

final class CurrencyNotFoundException extends InvalidArgumentException
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('Currency with id #%d not found.', $id));
    }
}
