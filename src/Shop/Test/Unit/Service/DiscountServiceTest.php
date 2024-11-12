<?php

declare(strict_types=1);

namespace App\Shop\Test\Unit\Service;

use App\Shop\Infrastructure\DiscountService;
use App\Shop\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class DiscountServiceTest extends TestCase
{
    private const CURRENCY = 'EUR';
    private readonly DiscountService $discountService;

    public function testMaxDiscount(): void
    {
        // Product with 15% discount by SKU and 30% by category - expect to apply the highest one
        $product = (new ProductBuilder())
            ->withSku('000003')
            ->withCategory('boots')
            ->withPrice($originalPrice = 10000)
            ->build()
        ;

        $result = $this->discountService->getDiscountedPrice($product);

        self::assertEquals(self::CURRENCY, $result->getCurrency());
        self::assertEquals($originalPrice, $result->getOriginal());
        self::assertEquals($originalPrice * 0.7, $result->getFinal());
        self::assertEquals('30%', $result->getDiscountPercentage());
    }

    public function testNoDiscount(): void
    {
        // Product with no discount
        $product = (new ProductBuilder())
            ->withSku('000001')
            ->withCategory('sandals')
            ->withPrice($originalPrice = 10000)
            ->build()
        ;

        $result = $this->discountService->getDiscountedPrice($product);

        self::assertEquals(self::CURRENCY, $result->getCurrency());
        self::assertEquals($originalPrice, $result->getOriginal());
        self::assertEquals($originalPrice, $result->getFinal());
        self::assertNull($result->getDiscountPercentage());
    }

    public function testSkuDiscount(): void
    {
        // Product with 15% discount by SKU
        $product = (new ProductBuilder())
            ->withSku('000003')
            ->withCategory('sandals')
            ->withPrice($originalPrice = 10000)
            ->build()
        ;

        $result = $this->discountService->getDiscountedPrice($product);

        self::assertEquals(self::CURRENCY, $result->getCurrency());
        self::assertEquals($originalPrice, $result->getOriginal());
        self::assertEquals($originalPrice * 0.85, $result->getFinal());
        self::assertEquals('15%', $result->getDiscountPercentage());
    }

    protected function setUp(): void
    {
        $this->discountService = new DiscountService();
    }
}
