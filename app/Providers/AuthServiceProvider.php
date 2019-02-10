<?php

namespace App\Providers;

use App\Services\IApiTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot(IApiTokenService $apiTokenService)
    {
        $this->app['auth']->viaRequest('api', function (Request $request) use ($apiTokenService) {
            $token = $request->input('api_token', $request->header('api-token', null));
            if ($token) {
                return $apiTokenService->findTokenAndAuth($token, $request->ip());
            }
            return null;
        });
    }
}
