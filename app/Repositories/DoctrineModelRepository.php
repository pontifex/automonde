<?php

namespace App\Repositories;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineModelRepository implements IModelRepository
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var IBrandRepository */
    private $brandRepository;

    public function __construct(
        EntityManagerInterface $em,
        IBrandRepository $brandRepository
    ) {
        $this->em = $em;
        $this->brandRepository = $brandRepository;
    }

    public function addOne(
        Model $model,
        string $brandId
    ) {
        $brand = $this->brandRepository->getOneById($brandId);

        $model->setBrand($brand);
        $this->em->persist($model);
        $this->em->flush();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Model
    {
        /** @var Model|null $model */
        $model = $this->em->find(Model::class, $id);

        if (null === $model) {
            throw new ResourceNotFoundException();
        }

        return $model;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        $modelsArr = $this->em->getRepository(Model::class)
            ->findBy([], null, $pageSize, ($pageNumber - 1) * $pageSize);

        return new ArrayCollection($modelsArr);
    }

    public function isUnique(string $slug, string $brandId): bool
    {
        $q = $this->em->createQueryBuilder()
            ->select('count(m.id)')
            ->from(Model::class, 'm')
            ->where('m.slug = :modelSlug')
            ->andWhere('m.brand = :brandId')
            ->setParameter('modelSlug', $slug)
            ->setParameter('brandId', $brandId)
            ->getQuery();

        return ((int) $q->getSingleScalarResult() === 0);
    }
}
