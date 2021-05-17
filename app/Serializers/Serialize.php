<?php

namespace App\Serializers;

use App\Domain\Entities\ISerializable;
use Doctrine\Common\Collections\Collection;

trait Serialize
{
    public function serializeCollection(
        ISerializer $serializer,
        Collection $collection,
        array $fields
    ): array
    {
        $serialized = [];
        foreach ($collection as $item) {
            $serialized[] = $serializer->serialize($item, $fields);
        }

        return [
            $serializer->getType() => $serialized,
        ];
    }

    public function serialize(
        ISerializer $serializer,
        ISerializable $serializable,
        array $fields
    ): array
    {
        return [
            $serializer->getType() => $serializer->serialize($serializable, $fields),
        ];
    }

    public function serializeId(
        ISerializer $serializer,
        string $id
    ): array
    {
        return [
            $serializer->getType() => [
                'id' => $id
            ]
        ];
    }
}
