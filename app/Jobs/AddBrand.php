<?php

namespace App\Jobs;

use App\Commands\AddBrandCommand;
use App\Domain\Entities\Brand;
use App\Events\BrandAdded;
use App\Repositories\IBrandRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Libs\Slug\Slug;
use Ramsey\Uuid\Uuid;

class AddBrand implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Slug;

    public function __construct(
        private AddBrandCommand $command
    ) {
    }

    public function handle(IBrandRepository $brandRepository): void
    {
        $brand = new Brand(
            Uuid::fromString($this->command->getId()),
            $this->command->getName(),
            $this->slug($this->command->getName())
        );

        $brandRepository->addOne(
            $brand
        );

        BrandAdded::dispatch($brand);
    }
}
