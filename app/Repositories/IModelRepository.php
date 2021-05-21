<?php

namespace App\Repositories;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\Collection;

interface IModelRepository
{
    public function addOne(
        Model $model
    );

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(
        string $id
    ): Model;

    public function list(int $pageNumber, int $pageSize): Collection;

    public function isUnique(string $slug, string $brandId): bool;
}
