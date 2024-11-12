<?php

declare(strict_types=1);

namespace App\Shop\Test\Unit\Entity;

use App\Shop\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testCreate(): void
    {
        $product = (new ProductBuilder())
            ->withSku($sku = '0000002')
            ->withName($name = 'Product name')
            ->withCategory($category = 'Category')
            ->withPrice($price = 100000)
            ->build()
        ;

        self::assertEquals($sku, $product->getSku());
        self::assertEquals($name, $product->getName());
        self::assertEquals($category, $product->getCategory());
        self::assertEquals($price, $product->getPrice());
    }
}
