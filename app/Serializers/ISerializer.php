<?php

namespace App\Serializers;

use App\Domain\Entities\ISerializable;

interface ISerializer
{
    public function serialize(ISerializable $brand, array $fields): array;

    public static function getType(): string;
}
