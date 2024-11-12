<?php

declare(strict_types=1);

namespace App\Shop\Domain\Repository;

use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Filter\ProductFilter;

interface ProductRepositoryInterface
{
    /**
     * Persists product entity.
     *
     * @param Product $product
     * @return void
     */
    public function add(Product $product): void;

    /**
     * Returns products array with filters applied.
     *
     * @param ProductFilter $filter
     * @param int $limit
     * @return Product[]
     */
    public function findAllWithFilter(ProductFilter $filter, int $limit): array;
}
