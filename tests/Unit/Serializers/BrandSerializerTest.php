<?php

namespace Tests\Unit\Serializers;

use App\Domain\Entities\Brand;
use App\Exceptions\WrongTypeException;
use App\Serializers\BrandSerializer;
use App\Serializers\Serialize;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Mocks\BrandFactory;
use Tests\Mocks\ModelFactory;

class BrandSerializerTest extends TestCase
{
    use Serialize;

    public function testSerializeBrandWithValidEntityShouldReturnArray()
    {
        $brandId = Uuid::uuid4();
        $modelId = Uuid::uuid4();

        $model = ModelFactory::make($modelId);
        $brand = BrandFactory::make($brandId, $model);

        $serialized = $this->serialize(
            app()->get(BrandSerializer::class),
            $brand,
            [
                BrandSerializer::getType() => Brand::getAllowedFields(),
            ]
        );

        $this->assertSame($brand->getId(), $serialized[BrandSerializer::getType()]['id']);
        $this->assertSame(
            mb_convert_case($brand->getName(), MB_CASE_UPPER),
            $serialized[BrandSerializer::getType()]['name']
        );
        $this->assertSame($brand->getSlug(), $serialized[BrandSerializer::getType()]['slug']);
    }

    public function testSerializeBrandWithWrongEntityShouldThrowException()
    {
        $this->expectException(
            WrongTypeException::class
        );

        $this->expectExceptionMessage(
            'Wrong type provided App\Domain\Entities\Model but expected App\Domain\Entities\Brand'
        );

        $modelId = Uuid::uuid4();
        $model = ModelFactory::make($modelId);

        $this->serialize(
            app()->get(BrandSerializer::class),
            $model,
            [
                BrandSerializer::getType() => Brand::getAllowedFields(),
            ]
        );
    }
}
