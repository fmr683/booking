<?php

namespace App\Http\Middleware;
use App\Http\Middleware\Session;

use Closure;

class UserAuthorization
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
        die(Session::getId());
        return $next($request);
    }
}
