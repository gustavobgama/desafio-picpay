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
    TransactionInterface,
    Consumer,
    User,
    Seller,
    Transaction
};
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // repositories
        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(ConsumerInterface::class, Consumer::class);
        $this->app->bind(SellerInterface::class, Seller::class);
        $this->app->bind(TransactionInterface::class, Transaction::class);

        // guzzle
        $this->app->bind(Client::class, function ($app) {
            return new Client([
                'base_uri' => 'http://127.0.0.1',
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        });

        // configure faker to use the pt_BR provider
        if ($this->app->environment('local', 'testing')) {
            $this->app->singleton(Generator::class, function ($app) {
                return Factory::create('pt_BR');
            });
        }
    }
}
