<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Product\List;

use App\Shop\Domain\DiscountServiceInterface;
use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Filter\ProductFilter;
use App\Shop\Domain\Repository\ProductRepositoryInterface;

final class Handler
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
        private readonly DiscountServiceInterface $discountService
    ) {}

    /**
     * Returns filtered and discounted products.
     *
     * @param ProductFilter $filter
     * @return ProductDTO[]
     */
    public function __invoke(ProductFilter $filter): array
    {
        $products = $this->products->findAllWithFilter($filter, 5);

        return array_map(function (Product $product) {
            $price = $this->discountService->getDiscountedPrice($product);
            return new ProductDTO(
                sku: $product->getSku(),
                name: $product->getName(),
                category: $product->getCategory(),
                price: [
                    'original' => $price->getOriginal(),
                    'final' => $price->getFinal(),
                    'discount_percentage' => $price->getDiscountPercentage(),
                    'currency' => $price->getCurrency(),
                ]
            );
        }, $products);
    }
}
