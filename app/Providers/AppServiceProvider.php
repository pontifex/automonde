<?php

namespace App\Providers;

use App\CacheManagers\RedisBrandCacheManager;
use App\CacheManagers\IBrandCacheManager;
use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Hydrators\Cache\BrandHydrator;
use App\Repositories\CachedBrandRepository;
use App\Repositories\DoctrineBrandRepository;
use App\Repositories\DoctrineModelRepository;
use App\Repositories\IBrandRepository;
use App\Repositories\IModelRepository;
use App\Serializers\BrandSerializer;
use App\Serializers\Cache\BrandSerializer as BrandCacheSerializer;
use App\Serializers\ModelSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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

        $this->app->bind(IBrandCacheManager::class, function ($app) {
            return new RedisBrandCacheManager(
                $app->get(BrandHydrator::class),
                $app->get(BrandCacheSerializer::class),
            );
        });

        $this->app->bind(IBrandRepository::class, function ($app) {
            return new CachedBrandRepository(
                $app->get(DoctrineBrandRepository::class),
                $app->get(IBrandCacheManager::class),
            );
        });

        $this->app->bind(AddModelController::class, function ($app) {
            return new AddModelController(
                $app->get(ModelSerializer::class)
            );
        });

        $this->app->bind(IModelRepository::class, function ($app) {
            return new DoctrineModelRepository(
                $app->get(EntityManagerInterface::class)
            );
        });

        // entity manager has to be same instance over entire system to avoid eg. persistence issues
        $this->app->singleton(EntityManagerInterface::class, function ($app) {
            return $app->get(ManagerRegistry::class)->getManager('default');
        });
    }

    public function boot(): void
    {
        //
    }
}
