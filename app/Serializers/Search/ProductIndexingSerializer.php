<?php

namespace App\Serializers\Search;

use App\Domain\Entities\ISerializable;
use App\Domain\Entities\Product;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializer;
use JetBrains\PhpStorm\ArrayShape;

class ProductIndexingSerializer implements ISerializer
{
    private const TYPE = 'products';

    public static function getType(): string
    {
        return self::TYPE;
    }

    #[ArrayShape(
        [
            'products' => [
                'index' => 'string',
                'id' => 'string',
                'body' => [
                    'description' => 'string',
                    'mileage_distance' => 'integer',
                    'price_amount' => 'integer',
                ],
            ]
        ]
    )]
    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Product) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', $serializable::class, Product::class)
            );
        }

        return [
            'index' => self::TYPE,
            'id' => $serializable->getId(),
            'body' => [
                'description' => $serializable->getDescription(),
                'mileage_distance' => $serializable->getMileage()->getDistance(),
                'price_amount' => $serializable->getPrice()->getAmount(),
            ],
        ];
    }
}
