<?php

namespace App\Infrastructure\Cart\Query;

use App\Application\Cart\Query\CartDetails\CartDetailsProductView;
use App\Application\Cart\Query\CartDetails\CartDetailsQuery;
use App\Application\Cart\Query\CartDetails\CartDetailsQueryParameters;
use App\Application\Cart\Query\CartDetails\CartDetailsView;
use App\Domain\Cart\CartProduct;
use App\Shared\Infrastructure\Query\DoctrineBaseQuery;

final class DoctrineCartDetailsQuery extends DoctrineBaseQuery implements CartDetailsQuery
{
    public function execute(CartDetailsQueryParameters $parameters): CartDetailsView
    {
        $fields = [
            'p.id',
            'p.title',
            'p.price',
            'cu.name',
            'cp.quantity',
        ];

        $qb = $this->createModelQueryBuilder(CartDetailsProductView::class, $fields)
            ->from(CartProduct::class, 'cp')
            ->leftJoin('cp.product', 'p')
            ->leftJoin('p.currency', 'cu')
            ->leftJoin('cp.cart','ca')
            ->where('ca.id = :cartId')
            ->setParameter('cartId', $parameters->id)
        ;

        return new CartDetailsView($qb->getQuery()->getResult());
    }
}
