<?php

namespace App\Application\Cart\Query\CartDetails;

interface CartDetailsQuery
{
    public function execute(CartDetailsQueryParameters $parameters): CartDetailsView;
}
