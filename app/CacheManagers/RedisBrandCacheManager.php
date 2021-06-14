<?php

namespace App\CacheManagers;

use App\CacheManagers\Exceptions\NotExistException;
use App\Domain\Entities\Brand;
use App\Domain\Entities\IHydrateable;
use App\Domain\Entities\ISerializable;
use App\Hydrators\Hydrate;
use App\Hydrators\IHydrator;
use App\Serializers\BrandSerializer;
use App\Serializers\ISerializer;
use App\Serializers\Serialize;
use Illuminate\Support\Facades\Redis;

class RedisBrandCacheManager implements IBrandCacheManager
{
    use Hydrate;
    use Serialize;

    private const CACHE_KEY_PATTERN_BRAND = '%s:%s';
    private const TIMEOUT = 360;

    public function __construct(
        private IHydrator $hydrator,
        private ISerializer $serializer
    ) {
        Redis::connection();
    }

    /**
     * @throws NotExistException
     */
    public function getOne(string $id): IHydrateable
    {
        $cacheKey = $this->buildCacheKey($id);

        if (Redis::exists($cacheKey)) {
            $encodedData = json_decode(Redis::get($cacheKey), true);
            return $this->hydrate($this->hydrator, $encodedData[BrandSerializer::getType()]);
        }

        throw new NotExistException();
    }

    public function add(ISerializable $serializable): void
    {
        $data = json_encode(
            $this->serialize(
                $this->serializer,
                $serializable,
                Brand::getAllowedFields()
            )
        );

        Redis::set(
            $this->buildCacheKey($serializable->getId()),
            $data,
            self::TIMEOUT
        );
    }

    public function flush(string $id): void
    {
        Redis::del($this->buildCacheKey($id));
    }

    private function buildCacheKey(string $id): string
    {
        return sprintf(
            self::CACHE_KEY_PATTERN_BRAND,
            Brand::class,
            $id
        );
    }
}
