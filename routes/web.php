<?php

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
    \App\Http\Controllers\Professor::setupRouter($router);
});

$router->group(['middleware' => 'professor_access'], function (\Laravel\Lumen\Routing\Router $router) {
    \App\Http\Controllers\Student::setupRouter($router);
    \App\Http\Controllers\Lesson::setupRouter($router);
});