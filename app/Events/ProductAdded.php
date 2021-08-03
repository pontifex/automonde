<?php

namespace App\Events;

use App\Domain\Entities\Product;
use Illuminate\Foundation\Events\Dispatchable;

final class ProductAdded
{
    use Dispatchable;

    public function __construct(
        private Product $product
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
