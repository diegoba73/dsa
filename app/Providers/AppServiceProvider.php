<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (auth()->check()) {
            // Obtiene el ID del departamento del usuario autenticado
            $userDepartamentoId = auth()->user()->departamento_id;
    
            // Comparte la variable $userDepartamentoId en todas las vistas
            View::share('userDepartamentoId', $userDepartamentoId);
        }
        setlocale(LC_TIME, 'es_ES.UTF-8');
    }
}
