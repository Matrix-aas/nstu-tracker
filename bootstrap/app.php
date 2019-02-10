<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/** Repositories bindings */

$app->singleton(
    \App\Services\Repositories\IApiTokenRepository::class,
    \App\Services\Repositories\ApiTokenRepository::class
);

$app->singleton(
    \App\Services\Repositories\Users\IStudentRepository::class,
    \App\Services\Repositories\Users\StudentRepository::class
);

$app->singleton(
    \App\Services\Repositories\Users\IProfessorRepository::class,
    \App\Services\Repositories\Users\ProfessorRepository::class
);

$app->singleton(
    \App\Services\Repositories\Users\IAdminRepository::class,
    \App\Services\Repositories\Users\AdminRepository::class
);

$app->singleton(
    \App\Services\Repositories\IGroupRepository::class,
    \App\Services\Repositories\GroupRepository::class
);

$app->singleton(
    \App\Services\Repositories\IVisitRepository::class,
    \App\Services\Repositories\VisitRepository::class
);

$app->singleton(
    \App\Services\Repositories\ILessonRepository::class,
    \App\Services\Repositories\LessonRepository::class
);

$app->singleton(
    \App\Services\Repositories\IDisciplineRepository::class,
    \App\Services\Repositories\DisciplineRepository::class
);

/** Services bindings */
$app->singleton(
    \App\Services\IApiTokenService::class,
    \App\Services\ApiTokenService::class
);

$app->singleton(
    \App\Services\Users\IAuthService::class,
    \App\Services\Users\AuthService::class
);

$app->singleton(
    \App\Services\Users\IStudentService::class,
    \App\Services\Users\StudentService::class
);

$app->singleton(
    \App\Services\Users\IAdminService::class,
    \App\Services\Users\AdminService::class
);

$app->singleton(
    \App\Services\Users\IProfessorService::class,
    \App\Services\Users\ProfessorService::class
);

$app->singleton(
    \App\Services\IGroupService::class,
    \App\Services\GroupService::class
);

$app->singleton(
    \App\Services\IVisitService::class,
    \App\Services\VisitService::class
);

$app->singleton(
    \App\Services\ILessonService::class,
    \App\Services\LessonService::class
);

$app->singleton(
    \App\Services\IDisciplineService::class,
    \App\Services\DisciplineService::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);

$app->middleware([
    App\Http\Middleware\JsonMiddleware::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

if ($app->environment() !== 'production') {
    $app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    $app->register(\Appzcoder\LumenRoutesList\RoutesCommandServiceProvider::class);
}

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
