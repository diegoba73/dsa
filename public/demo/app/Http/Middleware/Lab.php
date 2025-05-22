<?php

namespace App\Http\Middleware;

use Closure;

class Lab
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
        if (auth()->user()->departamento_id == 1) {
            return $next($request);
            
        }else {
            return redirect('/login');
        }
    }
}
