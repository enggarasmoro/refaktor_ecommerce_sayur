<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\BannerRepositoryInterface;
use App\Repositories\BannerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
    $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
    }

    public function boot()
    {
        //
    }
}
