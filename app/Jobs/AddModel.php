<?php

namespace App\Jobs;

use App\Commands\AddModelCommand;
use App\Domain\Entities\Model;
use App\Repositories\IBrandRepository;
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

    /** @var AddModelCommand */
    private $command;

    public function __construct(
        AddModelCommand $command
    ) {
        $this->command = $command;
    }

    public function handle(
        IModelRepository $modelRepository,
        IBrandRepository $brandRepository
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
    }
}
