<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Professor;
use App\Models\Users\Admin;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfessorAccessMiddleware extends Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        /** @var Response $response */
        $response = parent::handle($request, $next, $guard);
        if ($response->status() != 401 && ((!Auth::user() instanceof Admin) && (!Auth::user() instanceof Professor))) {
            return response('Forbidden.', 403);
        }
        return $response;
    }
}
