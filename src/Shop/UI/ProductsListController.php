<?php

declare(strict_types=1);

namespace App\Shop\UI;

use App\Shop\Application\UseCase\Product\List\Handler;
use App\Shop\Domain\Filter\ProductFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/products', name: 'shop_product_list')]
final class ProductsListController extends AbstractController
{
    public function __construct(
        private readonly Handler $handler
    ) {}

    public function __invoke(Request $request, ParameterBagInterface $params): JsonResponse
    {
        try {
            // Create form class if there are more fields and/or they need validation
            $command = new ProductFilter();
            $command->category = $request->query->get('category');

            $priceLessThan = $request->query->get('priceLessThan');

            if ($priceLessThan !== null) {
                $command->priceLessThan = (int) $priceLessThan;
            }

            $result = ($this->handler)($command);

            return new JsonResponse(['products' => $result]);
        } catch (\Exception) {
            return new JsonResponse('Something went wrong', 500);
        }
    }
}
