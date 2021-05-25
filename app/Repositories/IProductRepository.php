<?php

namespace App\Repositories;

use App\Domain\Entities\Product;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\Collection;

interface IProductRepository
{
    public function addOne(
        Product $product
    );

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Product;

    public function list(int $pageNumber, int $pageSize): Collection;
}
