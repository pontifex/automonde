<?php

namespace App\Jobs;

use App\Commands\AddModelCommand;
use App\Domain\Entities\Model;
use App\Events\ModelAdded;
use App\Repositories\DoctrineBrandRepository;
use App\Repositories\IModelRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Libs\Slug\Slug;
use Ramsey\Uuid\Uuid;

class AddModel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Slug;

    public function __construct(
        private AddModelCommand $command
    ) {
    }

    public function handle(
        IModelRepository $modelRepository,
        DoctrineBrandRepository $brandRepository
    ): void {
        $model = new Model(
            Uuid::fromString($this->command->getId()),
            $this->command->getName(),
            $this->slug($this->command->getName())
        );

        $model->setBrand(
            $brandRepository->getOneById(
                $this->command->getBrandId()
            )
        );

        $modelRepository->addOne(
            $model
        );

        ModelAdded::dispatch($model);
    }
}
