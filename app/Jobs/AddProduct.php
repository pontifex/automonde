<?php

namespace App\Jobs;

use App\Commands\AddProductCommand;
use App\Domain\Entities\Product;
use App\Domain\ValueObjects\Mileage;
use App\Domain\ValueObjects\Price;
use App\Events\ProductAdded;
use App\Repositories\DoctrineProductRepository;
use App\Repositories\IModelRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class AddProduct implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private AddProductCommand $command
    ) {
    }

    public function handle(
        DoctrineProductRepository $productRepository,
        IModelRepository $modelRepository
    ): void {
        $product = new Product(
            Uuid::fromString($this->command->getId()),
            new Mileage(
                $this->command->getMileageDistance(),
                $this->command->getMileageUnit()
            ),
            new Price(
                $this->command->getPriceAmount(),
                $this->command->getPriceCurrency()
            ),
            $this->command->getDescription()
        );

        $model = $modelRepository->getOneById($this->command->getModelId());
        $product->setModel($model);

        $productRepository->addOne(
            $product
        );

        ProductAdded::dispatch($product);
    }
}
