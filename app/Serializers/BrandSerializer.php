<?php

namespace App\Serializers;

use App\Domain\Entities\Brand;

class BrandSerializer implements IBrandSerializer
{
    use SerializeId;

    public function serialize(Brand $brand, array $fields): array
    {
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

        return [
            IBrandSerializer::TYPE => $serialized,
        ];
    }

    public function serializeId(string $id): array
    {
        return $this->serializeIdWithType(
            IBrandSerializer::TYPE,
            $id
        );
    }
}
