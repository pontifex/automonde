<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;
use Doctrine\Common\Collections\Collection;

interface IBrandRepository
{
    public function addOne(
        Brand $brand
    );

    public function getOneById(
        string $id
    ): Brand;

    public function list(int $pageNumber, int $pageSize): Collection;
}
