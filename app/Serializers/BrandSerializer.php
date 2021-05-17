<?php

namespace App\Serializers;

use App\Domain\Entities\Brand;
use App\Domain\Entities\ISerializable;

class BrandSerializer implements ISerializer
{
    private const TYPE = 'brands';

    public static function getType(): string
    {
        return self::TYPE;
    }

    public function serialize(ISerializable $brand, array $fields): array
    {
        if (! $brand instanceof Brand) {
            throw new \RuntimeException(
                sprintf('Wrong type provided %s but expected %s', get_class($brand), Brand::class)
            );
        }

        $serialized = [];
        foreach ($fields['brands'] as $field) {
            switch ($field) {
                case 'id':
                    $serialized['id'] = $brand->getId();
                    break;
                case 'name':
                    $serialized['name'] = mb_convert_case($brand->getName(), MB_CASE_UPPER);
                    break;
                case 'slug':
                    $serialized['slug'] = $brand->getSlug();
                    break;
            }
        }

        return $serialized;
    }
}
