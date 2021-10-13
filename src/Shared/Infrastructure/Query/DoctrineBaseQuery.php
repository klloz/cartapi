<?php

namespace App\Shared\Infrastructure\Query;

use App\Shared\Application\Query\PagedQueryParameters;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

abstract class DoctrineBaseQuery
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function createModelQueryBuilder(string $viewModel, array $fields): QueryBuilder
    {
        $fields = implode(',', $fields);

        return $this->entityManager->createQueryBuilder()
            ->select("new $viewModel ($fields)");
    }

    public function getPagedResult(QueryBuilder $queryBuilder, PagedQueryParameters $parameters): array
    {
        return $queryBuilder
            ->setFirstResult($parameters->getOffset())
            ->setMaxResults($parameters->getCount())
            ->getQuery()
            ->getResult();
    }
}
