<?php

namespace App\Repositories\Doctrine;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use Doctrine\ORM\EntityManagerInterface;

class BrandRepository implements IBrandRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addBrand(
        Brand $brand
    )
    {
        $this->em->persist($brand);
        $this->em->flush();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getBrandById(string $id): Brand
    {
        /** @var Brand|null $brand */
        $brand = $this->em->find(Brand::class, $id);

        if (null === $brand) {
            throw new ResourceNotFoundException();
        }

        return $brand;
    }
}