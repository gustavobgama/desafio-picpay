<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker \ {
    Generator,
    Factory
};

class AppServiceProvider extends ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        // configure faker (in local and test enviroments) to use the pt_BR provider
        if ($this->app->environment('local', 'testing')) {
            $this->app->singleton(Generator::class, function ($app) {
                return Factory::create('pt_BR');
            });
        }
    }
}
