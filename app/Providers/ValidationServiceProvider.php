<?php

namespace App\Providers;

use App\Repositories\IModelRepository;
use App\Serializers\ModelSerializer;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Libs\Slug\Slug;

class ValidationServiceProvider extends ServiceProvider
{
    use Slug;

    /** @var IModelRepository */
    private $modelRepository;

    public function boot()
    {
        $this->customValidations();
    }

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->modelRepository = $app->get(IModelRepository::class);
    }

    protected function customValidations(): void
    {
        $this->uniqueModel();
    }

    private function uniqueModel(): void
    {
        Validator::extend('unique_model', function ($attribute, $value, $parameters, $validator) {
            $validationData = $validator->getData();

            return $this->modelRepository->isUnique(
                $this->slug($value),
                $validationData[ModelSerializer::getType()]['brand_id'] ?? null
            );
        });

        Validator::replacer('unique_model', function () {
            return 'Model already exists';
        });
    }
}
