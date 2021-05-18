<?php

namespace App\Hydrators;

use App\Domain\Entities\IHydrateable;

interface IHydrator
{
    public function hydrate(array $data): IHydrateable;
}
