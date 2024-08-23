<?php

namespace App\Providers;
use App\Models\Employer;
use App\Policies\EmployerPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        Gate::define('create', function (User $user) {
            return null === $user->employer;
        });

        Gate::define('update', function (User $user, Employer $employer) {
            return $user->id === $employer->user_id;
        });
    }
}
