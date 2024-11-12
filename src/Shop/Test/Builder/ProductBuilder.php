<?php

declare(strict_types=1);

namespace App\Shop\Test\Builder;

use App\Shop\Domain\Entity\Product;

final class ProductBuilder
{
    private string $sku;
    private string $name;
    private string $category;
    private int $price;

    public function __construct()
    {
        $this->sku = '000001';
        $this->name = 'Product';
        $this->category = 'boots';
        $this->price = 80000;
    }

    public function withSku(string $sku): self
    {
        $clone = clone $this;
        $clone->sku = $sku;
        return $clone;
    }

    public function withName(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    public function withCategory(string $category): self
    {
        $clone = clone $this;
        $clone->category = $category;
        return $clone;
    }

    public function withPrice(int $price): self
    {
        $clone = clone $this;
        $clone->price = $price;
        return $clone;
    }

    public function build(): Product
    {
        return new Product(
            sku: $this->sku,
            name: $this->name,
            category: $this->category,
            price: $this->price
        );
    }
}
