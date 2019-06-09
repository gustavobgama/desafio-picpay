<?php
use Illuminate\Http\Request;

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
    $router->get('', 'UserController@index');
    $router->get('/{id}', 'UserController@show');
    $router->post('', 'UserController@store');

    $router->post('consumers', 'ConsumerController@store');
    $router->post('sellers', 'SellerController@store');
});

$router->group(['prefix' => 'transactions'], function () use ($router) {
    $router->post('', 'TransactionController@store');

    // "External" service for authorization, for sake of simplicity is included with current API
    $router->post('authorize', function (Request $request) {
        $value = $request->get('value');
        if ($value >= 100.00) {
            return response('Transação não autorizada', 401);
        } else {
            return response('OK');
        }
    });
});
