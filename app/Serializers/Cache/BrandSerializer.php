<?php

namespace App\Serializers\Cache;

use App\Domain\Entities\Brand;
use App\Domain\Entities\ISerializable;
use App\Exceptions\WrongTypeException;
use App\Serializers\ISerializer;

class BrandSerializer implements ISerializer
{
    private const TYPE = 'brands';

    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $serializable, array $fields): array
    {
        if (! $serializable instanceof Brand) {
            throw new WrongTypeException(
                sprintf('Wrong type provided %s but expected %s', get_class($serializable), Brand::class)
            );
        }

        $serialized = [];
        foreach ($fields as $field) {
            switch ($field) {
                case 'id':
                    $serialized['id'] = $serializable->getId();
                    break;
                case 'name':
                    $serialized['name'] = $serializable->getName();
                    break;
                case 'slug':
                    $serialized['slug'] = $serializable->getSlug();
                    break;
            }
        }

        return $serialized;
    }
}
