<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(ConsumerInterface::class, Consumer::class);
        $this->app->bind(SellerInterface::class, Seller::class);
        $this->app->bind(TransactionInterface::class, Transaction::class);
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            UserInterface::class,
            ConsumerInterface::class,
            SellerInterface::class,
            TransactionInterface::class,
        ];
    }
}
