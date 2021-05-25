<?php

namespace App\Events;

use App\Domain\Entities\Brand;
use Illuminate\Foundation\Events\Dispatchable;

final class BrandAdded
{
    use Dispatchable;

    private $brand;

    public function __construct(
        Brand $brand
    ) {
        $this->brand = $brand;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }
}
