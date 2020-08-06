<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Filo\Users\Domain\JwtAuth;
use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard("api")->check()) {
            return response(["message" => "Permission Denied"], 401);
        }
        return $next($request);
    }
}
