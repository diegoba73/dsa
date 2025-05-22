<?php

namespace App\Http\Middleware;

use Closure;

class Db
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
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (auth()->user()->role_id == 9 || auth()->user()->role_id == 1) {
            return $next($request);
            
        }else {
            return redirect('/login');
        }
    }
}
