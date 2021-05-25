<?php

namespace App\Events;

use App\Domain\Entities\Product;
use Illuminate\Foundation\Events\Dispatchable;

final class ProductAdded
{
    use Dispatchable;

    private $product;

    public function __construct(
        Product $product
    ) {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
