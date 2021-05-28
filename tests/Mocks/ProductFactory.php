<?php

namespace Tests\Mocks;

use App\Domain\Entities\Model;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use Ramsey\Uuid\UuidInterface;

class ProductFactory
{
    public static function make(UuidInterface $id, Model $model): Product
    {
        $product = new Product(
            $id,
            new Mileage(
                10000,
                Mileage::UNIT_KILOMETERS
            ),
            new Price(
                99999,
                Price::CURRENCY_EUR
            ),
            'I wanna sell my awesome car!'
        );

        $product->setModel($model);

        return $product;
    }
}
