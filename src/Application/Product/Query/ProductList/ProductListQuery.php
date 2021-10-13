<?php

namespace App\Application\Product\Query\ProductList;

use App\Shared\Application\Query\PagedQueryParameters;

interface ProductListQuery
{
    public function execute(PagedQueryParameters $parameters): ProductListView;
}
