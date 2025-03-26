<?php

namespace App\Providers;

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
        $this->register();

        // Implementing Laratrust permission for users
        \Gate::define('users-read', function ($user) {
            return $user->hasPermission('users-read');
        });
    }
    
}
