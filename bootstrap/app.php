<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

$app = new Laravel\Lumen\Application(dirname(__DIR__));

$app->withFacades();

$app->withEloquent();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/**
 * Application service providers
 */
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\RepositoryServiceProvider::class);
$app->register(App\Providers\ClientServiceProvider::class);

/**
 * Package service providers
 */
$app->register(Pearl\RequestValidate\RequestServiceProvider::class);

$app->configure('app');
$app->configure('database');
$app->configure('logging');

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/api.php';
});

return $app;
