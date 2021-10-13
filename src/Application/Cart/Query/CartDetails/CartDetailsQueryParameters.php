<?php

namespace App\Application\Cart\Query\CartDetails;

final class CartDetailsQueryParameters
{
    /**
     * @Assert\NotBlank()
     */
    public ?int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }
}
