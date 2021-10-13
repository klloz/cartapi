<?php

namespace App\Infrastructure\Cart;

use App\Domain\Cart\Cart;
use App\Domain\Cart\CartProduct;
use App\Domain\Cart\CartProducts;
use App\Domain\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineCartProducts implements CartProducts
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(CartProduct::class);
    }

    public function findProductInCart(Product $product, Cart $cart): ?CartProduct
    {
        try {
            return $this->entityManager->createQueryBuilder()
                ->select('cp')
                ->from(CartProduct::class, 'cp')
                ->leftJoin('cp.cart', 'c')
                ->leftJoin('cp.product', 'p')
                ->where('c = :cart')
                ->andWhere('p = :product')
                ->setParameter('cart', $cart)
                ->setParameter('product', $product)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
