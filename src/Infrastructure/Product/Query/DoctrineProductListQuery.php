<?php

namespace App\Infrastructure\Product\Query;

use App\Application\Product\Query\ProductList\ProductListItemView;
use App\Application\Product\Query\ProductList\ProductListQuery;
use App\Application\Product\Query\ProductList\ProductListView;
use App\Domain\Product\Product;
use App\Shared\Application\Query\PagedQueryParameters;
use App\Shared\Infrastructure\Query\DoctrineBaseQuery;

final class DoctrineProductListQuery extends DoctrineBaseQuery implements ProductListQuery
{
    public function execute(PagedQueryParameters $parameters): ProductListView
    {
        $fields = [
            'p.id',
            'p.title',
            'p.price',
            'c.name',
        ];

        $qb = $this->createModelQueryBuilder(ProductListItemView::class, $fields)
            ->from(Product::class, 'p')
            ->leftJoin('p.currency', 'c')
        ;

        $totalCount = count($qb->getQuery()->getResult());
        $data = $this->getPagedResult($qb, $parameters);

        return new ProductListView($totalCount, $data);
    }
}
