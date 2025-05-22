<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckUserActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
    
            // Agrega registros de depuración
            \Log::info('User ID: ' . $user->id);
            \Log::info('User Activo: ' . $user->activo);
    
            // Verifica si el usuario no está activo (activo = 0)
            if ($user->activo == 0) {
                // Si el usuario no está activo, cierra la sesión y redirige a una página de inactividad o inicio de sesión
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
            }
        }
    
        return $next($request);
    }
    
}
