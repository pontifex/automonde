<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;

interface IBrandRepository
{
    public function addBrand(
        Brand $brand
    );

    public function getBrandById(
        string $id
    ): Brand;
}
