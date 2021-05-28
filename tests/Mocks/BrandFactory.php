<?php

namespace Tests\Mocks;

use App\Domain\Entities\Brand;
use App\Domain\Entities\Model;
use Ramsey\Uuid\UuidInterface;

class BrandFactory
{
    public static function make(UuidInterface $id, Model $model): Brand
    {
        $brand = new Brand(
            $id,
            'Volvo',
            'volvo'
        );

        $brand->addModel($model);

        return $brand;
    }
}
