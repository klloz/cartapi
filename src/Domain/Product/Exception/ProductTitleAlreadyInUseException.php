<?php

namespace App\Domain\Product\Exception;

use InvalidArgumentException;

final class ProductTitleAlreadyInUseException extends InvalidArgumentException
{
    public function __construct(string $title)
    {
        parent::__construct(sprintf('Product with title \'%s\' already exists.', $title));
    }
}
