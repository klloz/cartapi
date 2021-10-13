<?php

namespace App\Infrastructure\Cart;

use App\Domain\Cart\Cart;
use App\Domain\Cart\Carts;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineCarts implements Carts
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Cart::class);
    }

    /**
     * @param int $id
     * @return Cart|Object|null
     */
    public function findById(int $id): ?Cart
    {
        return $this->repository->find($id);
    }

    public function add(Cart $cart): void
    {
        $this->entityManager->persist($cart);
    }

    public function remove(Cart $cart): void
    {
        $this->entityManager->remove($cart);
    }
}
