<?php

date_default_timezone_set('Asia/Novosibirsk');

/** @var \Laravel\Lumen\Routing\Router $router */

$router->options('{any:.*}', function () {
    return '';
});

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
    \App\Http\Controllers\Group::setupRouter($router, ['create', 'update', 'delete', 'attachLesson', 'detachLesson']);
    \App\Http\Controllers\Discipline::setupRouter($router, ['create', 'update', 'delete', 'attachProfessor', 'detachProfessor']);
    \App\Http\Controllers\Professor::setupRouter($router);
});

$router->group(['middleware' => 'professor_access'], function (\Laravel\Lumen\Routing\Router $router) {
    \App\Http\Controllers\Student::setupRouter($router);
    \App\Http\Controllers\Lesson::setupRouter($router, ['create', 'update', 'delete', 'attachGroup', 'detachGroup']);
    \App\Http\Controllers\Visit::setupRouter($router);
});

$router->group(['middleware' => 'student_access'], function (\Laravel\Lumen\Routing\Router $router) {
    \App\Http\Controllers\Group::setupRouter($router, ['findAll', 'findById']);
    \App\Http\Controllers\Discipline::setupRouter($router, ['findAll', 'findById', 'findByProfessorId']);
    \App\Http\Controllers\Lesson::setupRouter($router, ['findAll', 'findById']);
});

$router->get('time', function () {
    $dbTime = \Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw("SELECT NOW() as db_time;"));
    $dbTime = $dbTime[0]->db_time;
    return ['time' => \Carbon\Carbon::now()->format("Y-m-d H:i:s"),
        'timezone' => date_default_timezone_get(),
        'db' => $dbTime,
        'offset' => \Carbon\Carbon::now()->diffInHours(\Carbon\Carbon::parse($dbTime))];
});