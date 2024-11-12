<?php

namespace App\DataFixtures;

use App\Shop\Domain\Entity\Product;
use App\Shop\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProductFixtures extends Fixture
{
    private const FILEPATH = '/data/products.json';

    public function __construct(
        private readonly ParameterBagInterface $params,
        private readonly ProductRepositoryInterface $products
    ) {}

    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents($this->params->get('kernel.project_dir') . self::FILEPATH);
        $decodedData = json_decode($data, true);
        $products = $decodedData['products'];

        foreach ($products as $product) {
            $entity = new Product($product['sku'], $product['name'], $product['category'], $product['price']);
            // Also can be done with $manager, but it is repository's responsibility
            $this->products->add($entity);
        }

        $manager->flush();
    }
}
