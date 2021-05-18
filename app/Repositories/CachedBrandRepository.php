<?php

namespace App\Repositories;

use App\CacheManagers\Exceptions\NotExistException;
use App\CacheManagers\IBrandCacheManager;
use App\Domain\Entities\Brand;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\Common\Collections\Collection;

class CachedBrandRepository implements IBrandRepository
{
    /** @var IBrandRepository */
    private $decoratedRepository;

    /** @var IBrandCacheManager */
    private $brandCacheManager;

    public function __construct(
        IBrandRepository $decoratedRepository,
        IBrandCacheManager $brandCacheManager
    )
    {
        $this->decoratedRepository = $decoratedRepository;
        $this->brandCacheManager = $brandCacheManager;
    }

    public function addOne(
        Brand $brand
    )
    {
        $this->decoratedRepository->addOne($brand);
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getOneById(string $id): Brand
    {
        try {
            $brand = $this->brandCacheManager->getOne($id);
        } catch (NotExistException $e) {
            $brand = $this->decoratedRepository->getOneById($id);
            $this->brandCacheManager->add($brand);
        }

        return $brand;
    }

    public function list(int $pageNumber, int $pageSize): Collection
    {
        return $this->decoratedRepository->list($pageNumber, $pageSize);
    }

    public function isUniqueBySlug(string $slug): bool
    {
        return $this->decoratedRepository->isUniqueBySlug($slug);
    }
}
