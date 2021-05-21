<?php

namespace App\Hydrators;

use App\Domain\Entities\IHydrateable;

trait Hydrate
{
    public function hydrate(IHydrator $hydrator, array $data): IHydrateable
    {
        return $hydrator->hydrate($data);
    }
}
