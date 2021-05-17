<?php

namespace App\Jobs;

use App\Commands\AddBrandCommand;
use App\Domain\Entities\Brand;
use App\Services\BrandService;
use Libs\Slug\Slug;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class AddBrand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Slug;

    /** @var AddBrandCommand */
    private $command;

    public function __construct(AddBrandCommand $command)
    {
        $this->command = $command;
    }

    public function handle(BrandService $brandService)
    {
        $brand = new Brand(
            Uuid::fromString($this->command->getId()),
            $this->command->getName(),
            $this->slug($this->command->getName())
        );

        $brandService->addBrand(
            $brand
        );
    }
}
