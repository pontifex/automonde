<?php

namespace App\Serializers;

use App\Domain\Entities\Brand;

class BrandSerializer implements IBrandSerializer
{
    use SerializeId;

    public function serialize(Brand $brand): array
    {
        return [
            IBrandSerializer::TYPE => [
                'id' => $brand->getId(),
                'name' => mb_convert_case($brand->getName(), MB_CASE_UPPER)
            ]
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
