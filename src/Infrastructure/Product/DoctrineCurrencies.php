<?php

namespace App\Infrastructure\Product;

use App\Domain\Product\Currencies;
use App\Domain\Product\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class DoctrineCurrencies implements Currencies
{
    private EntityManagerInterface $entityManager;

    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Currency::class);
    }

    /**
     * @param int $id
     * @return Currency|Object|null
     */
    public function findById(int $id): ?Currency
    {
        return $this->repository->find($id);
    }

    public function getFormList(): array
    {
        $result = [];

        /** @var Currency $currency */
        foreach ($this->repository->findAll() as $currency) {
            $result[$currency->getName()] = $currency->getId();
        }

        return $result;
    }
}
