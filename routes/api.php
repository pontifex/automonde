<?php

use App\Http\Controllers\Commands\AddBrandController;
use App\Http\Controllers\Commands\AddModelController;
use App\Http\Controllers\Commands\AddProductController;
use App\Http\Controllers\Queries\ListBrandsController;
use App\Http\Controllers\Queries\ListProductsController;
use App\Http\Controllers\Queries\ShowBrandController;
use App\Http\Controllers\Queries\ShowProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// brands

Route::post(
    '/brands',
    [
        AddBrandController::class,
        'index'
    ]
);

Route::get(
    '/brands/{id}',
    [
        ShowBrandController::class,
        'index'
    ]
);

Route::get(
    '/brands',
    [
        ListBrandsController::class,
        'index'
    ]
);

// models

Route::post(
    '/models',
    [
        AddModelController::class,
        'index'
    ]
);

// products

Route::post(
    '/products',
    [
        AddProductController::class,
        'index'
    ]
);

Route::get(
    '/products/{id}',
    [
        ShowProductController::class,
        'index'
    ]
);

Route::get(
    '/products',
    [
        ListProductsController::class,
        'index'
    ]
);
