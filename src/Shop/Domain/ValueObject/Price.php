<?php

declare(strict_types=1);

namespace App\Shop\Domain\ValueObject;

final class Price
{
    private int $final;

    public function __construct(
        private readonly int $original,
        private readonly ?int $discountPercentage = null,
        private readonly string $currency = 'EUR'
    ) {
        $this->final = $discountPercentage
            ? (int) round($original * (1 - ($discountPercentage / 100)))
            : $original;
    }

    public function getOriginal(): int
    {
        return $this->original;
    }

    public function getFinal(): int
    {
        return $this->final;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discountPercentage ? "{$this->discountPercentage}%" : null;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
