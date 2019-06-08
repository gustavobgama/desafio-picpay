<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserInterface;
use App\Repositories\User;
use Faker\Generator;
use Faker\Factory;

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

        // configure faker to use the pt_BR provider
        if ($this->app->environment('local', 'testing')) {
            $this->app->singleton(Generator::class, function ($app) {
                return Factory::create('pt_BR');
            });
        }
    }
}
