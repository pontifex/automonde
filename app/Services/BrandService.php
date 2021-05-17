<?php

namespace App\Services;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Doctrine\BrandRepository;
use App\Repositories\IBrandRepository;
use Doctrine\Common\Collections\Collection;

class BrandService
{
    /** @var BrandRepository */
    private $brandRepository;

    public function __construct(
        IBrandRepository $brandRepository
    )
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllowedFields(): array
    {
        return $this->brandRepository->getAllowedFields();
    }

    public function addBrand(
        Brand $brand
    ): void
    {
        $this->brandRepository->addOne($brand);
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getBrandById(
        string $id
    ): Brand
    {
        return $this->brandRepository->getOneById($id);
    }

    public function listBrands(int $pageNumber, int $pageSize): Collection
    {
        return $this->brandRepository->list($pageNumber, $pageSize);
    }
}
