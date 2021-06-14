<?php

namespace App\Repositories;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineBrandRepository implements IBrandRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) { }

    public function addOne(
        Brand $brand
    ) {
        $this->em->persist($brand);
        $this->em->flush();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Brand
    {
        /** @var Brand|null $brand */
        $brand = $this->em->find(Brand::class, $id);

        if (null === $brand) {
            throw new ResourceNotFoundException();
        }

        return $brand;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        $brandsArr = $this->em->getRepository(Brand::class)
            ->findBy([], null, $pageSize, ($pageNumber - 1) * $pageSize);

        return new ArrayCollection($brandsArr);
    }

    public function isUniqueBySlug(string $slug): bool
    {
        $q = $this->em->createQueryBuilder()
            ->select('count(b.id)')
            ->from(Brand::class, 'b')
            ->where('b.slug = :brandSlug')
            ->setParameter('brandSlug', $slug)
            ->getQuery();

        return ((int) $q->getSingleScalarResult() === 0);
    }
}
