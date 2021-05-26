<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use App\SearchManagers\IProductSearchManager;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddProductToSearchManager implements ShouldQueue
{
    public $connection = 'redis';

    public $queue = 'default';

    private $productSearchManager;

    public function __construct(
        IProductSearchManager $productSearchManager
    ) {
        $this->productSearchManager = $productSearchManager;
    }

    public function handle(ProductAdded $event)
    {
        $this->productSearchManager->addOne($event->getProduct());
    }
}
