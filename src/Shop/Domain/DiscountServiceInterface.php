<?php

declare(strict_types=1);

namespace App\Shop\Domain;

use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\ValueObject\Price;

interface DiscountServiceInterface
{
    /**
     * Processes product and returns its discounted price.
     *
     * @param Product $product
     * @return Price
     */
    public function getDiscountedPrice(Product $product): Price;
}