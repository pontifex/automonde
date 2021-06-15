<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\SearchManagers\IProductSearchManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticSearchProductRepository implements IProductRepository
{
    public function __construct(
        private IProductRepository $decoratedRepository,
        private IProductSearchManager $productSearchManager
    ) { }

    public function addOne(
        Product $product
    ) {
        $this->decoratedRepository->addOne($product);
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Product
    {
        try {
            /** @var Product|null $product */
            $product = $this->productSearchManager->getOneById($id);
        } catch (Missing404Exception) {
            throw new ResourceNotFoundException();
        }

        return $product;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        $productsArr = $this->productSearchManager
            ->list(limit: $pageSize, offset: ($pageNumber - 1) * $pageSize);

        return new ArrayCollection($productsArr);
    }
}
