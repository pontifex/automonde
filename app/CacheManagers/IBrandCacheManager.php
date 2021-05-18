<?php

namespace App\CacheManagers;

use App\CacheManagers\Exceptions\NotExistException;
use App\Domain\Entities\IHydrateable;
use App\Domain\Entities\ISerializable;

interface IBrandCacheManager
{
    /**
     * @throws NotExistException
     */
    public function getOne(string $id): IHydrateable;

    public function add(ISerializable $serializable): void;

    public function flush(string $id): void;
}
