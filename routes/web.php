<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', 'JWTAuthController@register');
    $router->post('login', 'JWTAuthController@login'); 
    $router->get('profile', 'UserController@profile');

});


$router->get('/products', 'ProductController@index');
$router->get('/product/{id}', 'ProductController@show');
$router->post('/products', 'ProductController@create');
$router->put('/product/{id}', 'ProductController@update');
$router->delete('/product/{id}', 'ProductController@delete');
