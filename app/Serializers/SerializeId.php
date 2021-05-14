<?php

namespace App\Serializers;

trait SerializeId
{
    public function serializeIdWithType(string $type, string $id): array
    {
        return [
            $type => [
                'id' => $id,
            ]
        ];
    }
}
