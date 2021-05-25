<?php

namespace App\SearchManagers;

use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Ramsey\Uuid\Uuid;

class ElasticSearchProductSearchManager implements IProductSearchManager
{
    public function addOne(Product $product)
    {
    }

    public function getOneById(string $id): Product
    {
        return new Product(
            Uuid::uuid4(),
            new Mileage(
                100000,
                Mileage::UNIT_KILOMETERS
            ),
            new Price(
                9999,
                Price::CURRENCY_EUR
            ),
            'Awesome car looking for a new owner!'
        );
    }

    public function list(array $criteria = [], string $orderBy = null, int $limit = 15, int $offset = 0): array
    {
        return [];
    }
}
