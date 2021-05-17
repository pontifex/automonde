<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;

interface IBrandRepository
{
    public function addOne(
        Brand $brand
    );

    public function getOneById(
        string $id
    ): Brand;
}
