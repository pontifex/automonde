<?php

namespace Tests\Unit\Rules;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\IBrandRepository;
use App\Rules\ExistingBrand;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Mocks\BrandFactory;
use Tests\Mocks\ModelFactory;

class ExistingBrandTest extends TestCase
{
    public function testWithExistingBrandShouldFail()
    {
        app()->bind(IBrandRepository::class, function () {
            $brandRepositoryStub = $this->createMock(IBrandRepository::class);
            $brandRepositoryStub->method('getOneById')->willThrowException(
                new ResourceNotFoundException()
            );

            return $brandRepositoryStub;
        });

        /** @var ExistingBrand $existingBrand */
        $existingBrand = app()->get(ExistingBrand::class);

        $isBrandExisting = $existingBrand->passes('brand_id', Uuid::uuid4()->toString());

        $this->assertFalse($isBrandExisting);
    }

    public function testWithNotExistingBrandShouldPass()
    {
        app()->bind(IBrandRepository::class, function () {
            $modelId = Uuid::uuid4();
            $model = ModelFactory::make($modelId);

            $brandId = Uuid::uuid4();
            $brand = BrandFactory::make($brandId, $model);

            $brandRepositoryStub = $this->createMock(IBrandRepository::class);
            $brandRepositoryStub->method('getOneById')->willReturn($brand);

            return $brandRepositoryStub;
        });

        /** @var ExistingBrand $existingBrand */
        $existingBrand = app()->get(ExistingBrand::class);

        $isBrandExisting = $existingBrand->passes('brand_id', Uuid::uuid4()->toString());

        $this->assertTrue($isBrandExisting);
    }
}
