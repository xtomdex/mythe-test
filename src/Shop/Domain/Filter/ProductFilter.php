<?php

declare(strict_types=1);

namespace App\Shop\Domain\Filter;

final class ProductFilter
{
    public ?string $category = null;
    public ?int $priceLessThan = null;
}
