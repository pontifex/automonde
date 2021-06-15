<?php

namespace App\Serializers;

use App\Domain\Entities\ISerializable;
use App\Domain\Entities\Product;
use App\Exceptions\WrongTypeException;

class ProductSerializer implements ISerializer
{
    private const TYPE = 'products';

    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Product) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', $serializable::class, Product::class)
            );
        }

        $serialized = [];
        foreach ($fields[self::TYPE] as $field) {
            switch ($field) {
                case 'id':
                    $serialized['id'] = $serializable->getId();
                    break;
                case 'description':
                    $serialized['description'] = $serializable->getDescription();
                    break;
                case 'mileage':
                    $serialized['mileage_distance'] = $serializable->getMileage()->getDistance();
                    $serialized['mileage_unit'] = $serializable->getMileage()->getUnit();
                    break;
                case 'price':
                    $serialized['price_amount'] = $serializable->getPrice()->getAmount();
                    $serialized['price_currency'] = $serializable->getPrice()->getCurrency();
                    break;
            }
        }

        return $serialized;
    }
}
