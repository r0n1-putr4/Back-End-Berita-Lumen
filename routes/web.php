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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->post('/users/login', 'UserController@login');

$router->get('/kontens', 'KontenController@index');
$router->post('/kontens', 'KontenController@store');
$router->delete('/kontens/{id}', 'KontenController@destroy');

