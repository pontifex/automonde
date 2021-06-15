<?php

namespace App\Providers;

use App\CacheManagers\RedisBrandCacheManager;
use App\CacheManagers\IBrandCacheManager;
use App\Console\Commands\ElasticSearchProductsIndexing;
use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Commands\AddProductController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ListProductsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Http\Controllers\Queries\ShowProductController;
use App\Hydrators\ArrayProductHydrator;
use App\Hydrators\Cache\BrandHydrator;
use App\Hydrators\SearchProductHydrator;
use App\Indexers\ElasticSearchBulkProductsIndexer;
use App\Repositories\CachedBrandRepository;
use App\Repositories\DoctrineBrandRepository;
use App\Repositories\DoctrineModelRepository;
use App\Repositories\DoctrineProductRepository;
use App\Repositories\ElasticSearchProductRepository;
use App\Repositories\IBrandRepository;
use App\Repositories\IModelRepository;
use App\Repositories\IProductRepository;
use App\SearchManagers\ElasticSearchProductSearchManager;
use App\SearchManagers\IProductSearchManager;
use App\Serializers\BrandSerializer;
use App\Serializers\Cache\BrandSerializer as BrandCacheSerializer;
use App\Serializers\ModelSerializer;
use App\Serializers\Search\ProductIndexingSerializer;
use App\Serializers\ProductSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
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

        $this->app->bind(AddProductController::class, function ($app) {
            return new AddProductController(
                $app->get(ProductSerializer::class)
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

        // entity manager has to be same instance over entire system to avoid eg. persistence issues
        $this->app->singleton(EntityManagerInterface::class, function ($app) {
            return $app->get(ManagerRegistry::class)->getManager('default');
        });

        $this->app->bind(IModelRepository::class, function ($app) {
            return new DoctrineModelRepository(
                $app->get(EntityManagerInterface::class)
            );
        });

        $this->app->bind(IProductSearchManager::class, function ($app) {
            return new ElasticSearchProductSearchManager(
                $app->get(Client::class),
                $app->get(ArrayProductHydrator::class),
                $app->get(SearchProductHydrator::class),
                $app->get(ProductIndexingSerializer::class),
            );
        });

        $this->app->bind(IProductRepository::class, function ($app) {
            return new ElasticSearchProductRepository(
                $app->get(DoctrineProductRepository::class),
                $app->get(IProductSearchManager::class),
            );
        });

        $this->app->bind(ListProductsController::class, function ($app) {
            return new ListProductsController(
                $app->get(IProductRepository::class),
                $app->get(ProductSerializer::class)
            );
        });

        $this->app->bind(ShowProductController::class, function ($app) {
            return new ShowProductController(
                $app->get(IProductRepository::class),
                $app->get(ProductSerializer::class)
            );
        });

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setSSLVerification(false)
                ->setHosts(
                    [
                        sprintf(
                            '%s:%d',
                            env('ELASTICSEARCH_HOST'),
                            env('ELASTICSEARCH_HOST_HTTP_PORT')
                        )
                    ]
                )->build();
        });

        $this->app->bind(ElasticSearchProductsIndexing::class, function ($app) {
            return new ElasticSearchProductsIndexing(
                $app->get(ElasticSearchBulkProductsIndexer::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
