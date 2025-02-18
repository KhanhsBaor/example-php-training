<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Services\Interface\AuthInterface;
use App\Services\Interface\UserInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind AuthInterface to AuthService
        $this->app->bind(AuthInterface::class, AuthService::class);  
          
         // Bind UserInterface to UserService
        $this->app->bind(UserInterface::class, UserService::class);
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
