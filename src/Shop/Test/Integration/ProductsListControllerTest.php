<?php

declare(strict_types=1);

namespace App\Shop\Test\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ProductsListControllerTest extends WebTestCase
{
    public function testGetProductsWithoutFilters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $responseData);
        $this->assertIsArray($responseData['products']);

        $this->assertNotEmpty($responseData['products']);

        $sampleProduct = $responseData['products'][0];
        $this->assertArrayHasKey('sku', $sampleProduct);
        $this->assertArrayHasKey('name', $sampleProduct);
        $this->assertArrayHasKey('category', $sampleProduct);
        $this->assertArrayHasKey('price', $sampleProduct);

        $this->assertArrayHasKey('original', $sampleProduct['price']);
        $this->assertArrayHasKey('final', $sampleProduct['price']);
        $this->assertArrayHasKey('discount_percentage', $sampleProduct['price']);
        $this->assertArrayHasKey('currency', $sampleProduct['price']);
    }

    public function testGetProductsWithCategoryFilter(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products', ['category' => 'boots']);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $responseData);
        $this->assertIsArray($responseData['products']);

        foreach ($responseData['products'] as $product) {
            $this->assertEquals('boots', $product['category']);
        }
    }

    public function testGetProductsWithPriceFilter(): void
    {
        $client = static::createClient();

        $client->request('GET', '/products', ['priceLessThan' => 80000]);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $responseData);
        $this->assertIsArray($responseData['products']);

        foreach ($responseData['products'] as $product) {
            $this->assertLessThan(80000, $product['price']['original']);
        }
    }
}
