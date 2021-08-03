<?php

namespace App\Events;

use App\Domain\Entities\Brand;
use Illuminate\Foundation\Events\Dispatchable;

final class BrandAdded
{
    use Dispatchable;

    public function __construct(
        private Brand $brand
    ) {
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }
}
