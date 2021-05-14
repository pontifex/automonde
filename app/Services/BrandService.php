<?php

namespace App\Services;

use App\Domain\Entities\Brand;
use App\Repositories\Doctrine\BrandRepository;
use App\Repositories\IBrandRepository;

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

    public function addBrand(
        Brand $brand
    ): void
    {
        $this->brandRepository->addBrand($brand);
    }

    public function getBrandById(
        string $id
    ): ?Brand
    {
        return $this->brandRepository->getBrandById($id);
    }
}
