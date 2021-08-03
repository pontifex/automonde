<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use App\SearchManagers\IProductSearchManager;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddProductToSearchManager implements ShouldQueue
{
    public string $connection = 'redis';

    public string $queue = 'default';

    public function __construct(
        private IProductSearchManager $productSearchManager
    ) {
    }

    public function handle(ProductAdded $event)
    {
        $this->productSearchManager->addOne($event->getProduct());
    }
}
