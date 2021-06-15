<?php

namespace App\Serializers\Search;

use App\Domain\Entities\ISerializable;
use App\Domain\Entities\Product;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializer;

class ProductBulkIndexingSerializer implements ISerializer
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

        $serialized[] = [
            'index' => [
                '_index' => self::TYPE,
                '_id' => $serializable->getId(),
            ],
        ];

        $serialized[] = [
            'description' => $serializable->getDescription(),
            'price_amount' => $serializable->getPrice()->getAmount(),
            'mileage_distance' => $serializable->getMileage()->getDistance(),
        ];

        return $serialized;
    }
}
