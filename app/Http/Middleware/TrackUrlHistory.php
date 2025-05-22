<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackUrlHistory
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
        // Definir rutas que no se deben almacenar en el historial
        $excludedRoutes = [
            'login',
            'logout',
            'register',
            // Añade otras rutas que quieras excluir
        ];

        // Obtener el nombre de la ruta actual
        $currentRoute = $request->route() ? $request->route()->getName() : null;

        // Si la ruta actual está en la lista de excluidas, no la almacenamos
        if ($currentRoute && in_array($currentRoute, $excludedRoutes)) {
            return $next($request);
        }

        // Obtener la URL actual
        $currentUrl = $request->fullUrl();

        // Obtener el historial de URLs desde la sesión
        $urlHistory = $request->session()->get('url_history', []);

        // Añadir la URL actual al inicio del historial
        array_unshift($urlHistory, $currentUrl);

        // Limitar el historial a las últimas 5 URLs
        $urlHistory = array_slice($urlHistory, 0, 5);

        // Guardar el historial de vuelta en la sesión
        $request->session()->put('url_history', $urlHistory);

        return $next($request);
    }
}
