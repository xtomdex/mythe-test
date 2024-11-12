<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure;

use App\Shop\Domain\DiscountServiceInterface;
use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\ValueObject\Price;

final class DiscountService implements DiscountServiceInterface
{
    public function getDiscountedPrice(Product $product): Price
    {
        $originalPrice = $product->getPrice();
        $discounts = [];

        if (strtolower($product->getCategory()) === 'boots') {
            $discounts[] = 30;
        }

        if ($product->getSku() === '000003') {
            $discounts[] = 15;
        }

        // Apply max discount
        $discountPercentage = !empty($discounts) ? max($discounts) : null;

        return new Price($originalPrice, $discountPercentage);
    }
}
