<?php

namespace App\Repositories;

use App\Domain\Entities\Model;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineModelRepository implements IModelRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) { }

    public function addOne(
        Model $model
    ) {
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
            ->findBy(criteria: [], limit: $pageSize, offset: ($pageNumber - 1) * $pageSize);

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
