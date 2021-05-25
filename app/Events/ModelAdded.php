<?php

namespace App\Events;

use App\Domain\Entities\Model;
use Illuminate\Foundation\Events\Dispatchable;

final class ModelAdded
{
    use Dispatchable;

    private $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
