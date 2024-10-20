<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\CompanyRepositoryInterface::class,
            \App\Repositories\CompanyRepository::class);

        $this->app->bind(
            \App\Repositories\ProjectRepositoryInterface::class,
            \App\Repositories\ProjectRepository::class
        );

        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
