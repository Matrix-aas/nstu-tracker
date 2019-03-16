<?php

namespace App\Http\Middleware;

use Closure;

class StudentAccessMiddleware extends Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        return parent::handle($request, $next, $guard);
    }
}
