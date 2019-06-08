<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserInterface;
use App\Repositories\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, User::class);
    }
}
