<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure;

use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Filter\ProductFilter;
use App\Shop\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ProductRepository implements ProductRepositoryInterface
{
    private ObjectRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->repository = $entityManager->getRepository(Product::class);
    }

    public function add(Product $product): void
    {
        $this->entityManager->persist($product);
    }

    public function findAllWithFilter(ProductFilter $filter, int $limit = 5): array
    {
        $qb = $this->repository->createQueryBuilder('p');

        if (null !== $filter->category) {
            $qb->andWhere('p.category = :category')->setParameter('category', $filter->category);
        }

        if (null !== $filter->priceLessThan) {
            $qb->andWhere('p.price < :price')->setParameter('price', $filter->priceLessThan);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
