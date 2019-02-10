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

$router->group(['prefix' => 'auth'], function (\Laravel\Lumen\Routing\Router $router) {
    $router->post('student', "Authorization@authStudent");
    $router->post('professor', "Authorization@authProfessor");
    $router->post('admin', "Authorization@authAdmin");
    $router->group(['middleware' => 'auth'], function (\Laravel\Lumen\Routing\Router $router) {
        $router->get(null, "Authorization@getAllData");
        $router->post('logout', "Authorization@logout");
    });
});

/** == Authorized requests == */
$router->group(['middleware' => 'admin_access'], function (\Laravel\Lumen\Routing\Router $router) {
    \App\Http\Controllers\Group::setupRouter($router);
    \App\Http\Controllers\Discipline::setupRouter($router);
});