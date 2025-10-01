<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BannerController;

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

Route::prefix('v1')->group(function(){
    // Mobile categories endpoint
    Route::get('/categories', [KategoriController::class, 'getMobileKategori']);
    // Mobile banners endpoint
    Route::get('/banners', [BannerController::class, 'index']);

    // Products endpoint for mobile infinite scroll
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/{id}/related', [ProductController::class, 'related']);
});

// Deprecation handlers for unversioned endpoints (force clients to migrate)
Route::middleware([])->group(function(){
    $deprecated = function($resource){
        return response()->json([
            'success' => false,
            'code' => 'deprecated_endpoint',
            'message' => 'Endpoint tidak lagi tersedia. Gunakan /api/v1/' . $resource,
        ], 410); // 410 Gone
    };
    Route::get('/categories', fn() => $deprecated('categories'));
    Route::get('/banners', fn() => $deprecated('banners'));
    Route::get('/products', fn() => $deprecated('products'));
    Route::get('/products/{id}', fn() => $deprecated('products/{id}'));
});
