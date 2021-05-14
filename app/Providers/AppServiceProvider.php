<?php

namespace App\Providers;

use App\Repositories\Doctrine\BrandRepository;
use App\Services\BrandService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BrandService::class, function ($app) {
            return new BrandService(
                $app->get(BrandRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
