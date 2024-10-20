<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::policy(Project::class, ProjectPolicy::class);
//        Gate::policy(Company::class, CompanyPolicy::class);
//        Gate::policy(User::class, UserPolicy::class);
    }
}
