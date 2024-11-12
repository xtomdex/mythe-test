<?php

declare(strict_types=1);

namespace App\Shop\Test\Unit\UseCase;

use App\Shop\Application\UseCase\Product\List\Handler;
use App\Shop\Application\UseCase\Product\List\ProductDTO;
use App\Shop\Domain\DiscountServiceInterface;
use App\Shop\Domain\Filter\ProductFilter;
use App\Shop\Domain\Repository\ProductRepositoryInterface;
use App\Shop\Domain\ValueObject\Price;
use App\Shop\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class ProductsListTest extends TestCase
{
    private readonly ProductRepositoryInterface $repository;
    private readonly DiscountServiceInterface $discountService;
    private readonly Handler $handler;

    public function testSuccess(): void
    {
        $products = [
            (new ProductBuilder())
                ->withSku('000001')
                ->withName('Product 1')
                ->withCategory('boots')
                ->withPrice(10000)
                ->build(),
            (new ProductBuilder())
                ->withSku('000002')
                ->withName('Product 2')
                ->withCategory('sandals')
                ->withPrice(20000)
                ->build()
        ];

        $this->repository->method('findAllWithFilter')->willReturn($products);
        $this->discountService
            ->expects($this->exactly(2))
            ->method('getDiscountedPrice')
            ->willReturn(
                new Price(10000, 30),
                new Price(20000, null)
            )
        ;
        $command = new ProductFilter();
        $result = ($this->handler)($command);
        $expected = [
            new ProductDTO(
                sku: '000001',
                name: 'Product 1',
                category: 'boots',
                price: [
                    'original' => 10000,
                    'final' => 7000,
                    'discount_percentage' => '30%',
                    'currency' => 'EUR'
                ]
            ),
            new ProductDTO(
                sku: '000002',
                name: 'Product 2',
                category: 'sandals',
                price: [
                    'original' => 20000,
                    'final' => 20000,
                    'discount_percentage' => null,
                    'currency' => 'EUR'
                ]
            ),
        ];

        self::assertEquals($expected, $result);
    }

    protected function setUp(): void
    {
        $this->repository = $this->createMock(ProductRepositoryInterface::class);
        $this->discountService = $this->createMock(DiscountServiceInterface::class);
        $this->handler = new Handler($this->repository, $this->discountService);
    }
}
