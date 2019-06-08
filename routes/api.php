<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('', 'UserController@list');
    $router->post('', 'UserController@store');

    $router->post('consumers', 'ConsumerController@store');
    $router->post('sellers', 'SellerController@store');
});
