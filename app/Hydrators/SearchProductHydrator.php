<?php

namespace App\Hydrators;

use App\Domain\Entities\IHydrateable;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Ramsey\Uuid\Uuid;

class SearchProductHydrator implements IHydrator
{
    public function hydrate(array $data): IHydrateable
    {
        return new Product(
            Uuid::fromString($data['_id']),
            new Mileage(
                $data['_source']['mileage_distance'],
                Mileage::UNIT_KILOMETERS
            ),
            new Price(
                $data['_source']['price_amount'],
                Price::CURRENCY_EUR
            ),
            $data['_source']['description']
        );
    }
}
