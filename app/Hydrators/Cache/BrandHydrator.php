<?php

namespace App\Hydrators\Cache;

use App\Domain\Entities\Brand;
use App\Domain\Entities\IHydrateable;
use App\Hydrators\IHydrator;
use Ramsey\Uuid\Uuid;

class BrandHydrator implements IHydrator
{
    public function hydrate(array $data): IHydrateable
    {
        return new Brand(
            Uuid::fromString($data['id']),
            $data['name'],
            $data['slug'],
        );
    }
}
