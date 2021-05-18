<?php

namespace App\Providers;

use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Repositories\Doctrine\BrandRepository;
use App\Repositories\IBrandRepository;
use App\Serializers\BrandSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddBrandController::class, function ($app) {
            return new AddBrandController(
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(ListBrandsController::class, function ($app) {
            return new ListBrandsController(
                $app->get(IBrandRepository::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(ShowBrandController::class, function ($app) {
            return new ShowBrandController(
                $app->get(IBrandRepository::class),
                $app->get(BrandSerializer::class)
            );
        });

        $this->app->bind(IBrandRepository::class, function ($app) {
            return new BrandRepository(
                $app->get(EntityManagerInterface::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
