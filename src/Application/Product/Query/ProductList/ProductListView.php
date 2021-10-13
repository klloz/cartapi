<?php

namespace App\Application\Product\Query\ProductList;

final class ProductListView
{
    public int $totalCount;

    /**
     * @var ProductListItemView[]
     */
    public array $data;

    public function __construct(int $totalCount, array $data = [])
    {
        $this->totalCount = $totalCount;
        $this->data = $data;
    }
}
