<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class AllowedUsers
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
        $userId = bmUsers();
        $routes = array('booking.edit','booking.create','booking.index', 'booking.store', 'booking.update', 'booking.show','home','');


        switch($request->route()->getName()) {
            case "login":
            case "logout":
                    return $next($request);
                break;
            default:
                if (in_array(\Auth::id(), $userId) && !in_array($request->route()->getName(), $routes)) {
                    return redirect('/');
                }
        }
         return $next($request);


    }
}
