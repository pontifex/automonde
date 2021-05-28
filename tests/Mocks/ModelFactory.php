<?php

namespace Tests\Mocks;

use App\Domain\Entities\Model;
use Ramsey\Uuid\UuidInterface;

class ModelFactory
{
    public static function make(UuidInterface $id): Model
    {
        return new Model(
            $id,
            'V50',
            'v50'
        );
    }
}
