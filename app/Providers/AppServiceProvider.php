<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Category\CategoryRepositoryContract;
use App\Contracts\Product\ProductImageRepositoryContract;
use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\User\UserRepositoryContract;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductImageRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductImageRepositoryContract::class, ProductImageRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
