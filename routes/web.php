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

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response("Welcome to nstu-tracker restful api server.");
});

$router->group(['prefix' => 'professor'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->get(null, "Professor@findAll");
});

$router->group(['prefix' => 'group'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->get(null, "Group@findAll");
});
