<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use App\SearchManagers\IProductSearchManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ElasticSearchProductRepository implements IProductRepository
{
    /** @var IProductRepository */
    private $decoratedRepository;

    /** @var IProductSearchManager */
    private $productSearchManager;

    public function __construct(
        IProductRepository $decoratedRepository,
        IProductSearchManager $productSearchManager
    ) {
        $this->decoratedRepository = $decoratedRepository;
        $this->productSearchManager = $productSearchManager;
    }

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
        /** @var Product|null $product */
        $product = $this->productSearchManager->getOneById($id);

        if (null === $product) {
            throw new ResourceNotFoundException();
        }

        return $product;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        $productsArr = $this->productSearchManager
            ->list([], null, $pageSize, ($pageNumber - 1) * $pageSize);

        return new ArrayCollection($productsArr);
    }
}
