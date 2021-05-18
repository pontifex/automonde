<?php

namespace App\Repositories\Doctrine;

use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class BrandRepository implements IBrandRepository
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
        ];
    }

    public function addOne(
        Brand $brand
    )
    {
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
            throw new ResourceNotFoundException('Not found');
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
            ->where('b.slug = :brandName')
            ->setParameter('brandName', $slug)
            ->getQuery();

        return ((int) $q->getSingleScalarResult() === 0);
    }
}
