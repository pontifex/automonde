<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\Collection;

interface IBrandRepository
{
    public function addOne(
        Brand $brand
    );

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Brand;

    public function list(int $pageNumber, int $pageSize): Collection;

    public function isUniqueBySlug(string $slug): bool;
}
