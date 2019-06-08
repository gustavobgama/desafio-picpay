<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker \ {
    Generator,
    Factory
};
use App\Repositories \ {
    ConsumerInterface,
    UserInterface,
    SellerInterface,
    Consumer,
    User,
    Seller
};

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
        $this->app->bind(ConsumerInterface::class, Consumer::class);
        $this->app->bind(SellerInterface::class, Seller::class);

        // configure faker to use the pt_BR provider
        if ($this->app->environment('local', 'testing')) {
            $this->app->singleton(Generator::class, function ($app) {
                return Factory::create('pt_BR');
            });
        }
    }
}
