<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Product\List;

final class ProductDTO
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly string $category,
        public readonly array $price
    ) {}
}
