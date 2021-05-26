<?php

namespace App\Hydrators;

use App\Domain\Entities\IHydrateable;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Ramsey\Uuid\Uuid;

class ArrayProductHydrator implements IHydrator
{
    public function hydrate(array $data): IHydrateable
    {
        return new Product(
            Uuid::fromString($data['id']),
            new Mileage(
                $data['mileage_distance'],
                Mileage::UNIT_KILOMETERS
            ),
            new Price(
                $data['price_amount'],
                Price::CURRENCY_EUR
            ),
            $data['description']
        );
    }
}
