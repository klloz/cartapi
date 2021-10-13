<?php

namespace App\Infrastructure\Product;

use App\Domain\Product\Product;
use App\Domain\Product\Products;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineProducts implements Products
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Product::class);
    }

    /**
     * @param int $id
     * @return Product|Object|null
     */
    public function findById(int $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function findByTitle(string $title): ?Product
    {
        try {
            return $this->entityManager->createQueryBuilder()
                ->select('p')
                ->from(Product::class, 'p')
                ->where('LOWER(p.title) = :title')
                ->setParameter('title', $title)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function add(Product $product): void
    {
        $this->entityManager->persist($product);
    }

    public function remove(Product $product): void
    {
        $this->entityManager->remove($product);
    }
}
