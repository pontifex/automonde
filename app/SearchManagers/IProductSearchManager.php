<?php

namespace App\SearchManagers;

use App\Domain\Entities\Product;

interface IProductSearchManager
{
    public function addOne(Product $product);

    public function getOneById(string $id): ?Product;

    public function list(array $criteria = [], string $orderBy = null, int $limit = 15, int $offset = 0): array;
}
