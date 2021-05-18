<?php

namespace App\Hydrators;

use App\Domain\Entities\ISerializable;

trait Hydrate
{
    public function hydrate(IHydrator $hydrator, array $data): ISerializable
    {
        return $hydrator->hydrate($data);
    }
}
