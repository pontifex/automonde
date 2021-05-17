<?php

namespace App\Serializers;

use App\Domain\Entities\Brand;

interface IBrandSerializer
{
    public const TYPE = 'brands';

    public function serialize(Brand $brand, array $fields): array;

    public function serializeId(string $id): array;
}
