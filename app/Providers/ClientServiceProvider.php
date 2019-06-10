<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class ClientServiceProvider extends ServiceProvider
{

    /**
     * @inheritDoc
     */
    protected $defer = true;

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app) {
            return new Client([
                'base_uri' => 'http://127.0.0.1',
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        });
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            Client::class,
        ];
    }
}
