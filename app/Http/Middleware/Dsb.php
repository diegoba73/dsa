<?php

namespace App\Http\Middleware;

use Closure;

class Dsb
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
        if ((auth()->user()->role_id == 11) || (auth()->user()->role_id == 1) || (auth()->user()->id == 6)) {
            return $next($request);
            
        }else {
            return redirect('/login');
        }
    }
}
