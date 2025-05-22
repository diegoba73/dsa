<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsultaIAController extends Controller
{
    protected $intenciones;

    public function __construct()
    {
        $this->intenciones = [
            'cantidad_muestras_2024' => [
                'match' => ['cuantas muestras.*2024', 'cantidad de muestras.*2024'],
                'consulta' => function () {
                    $cantidad = DB::table('muestras')
                        ->whereYear('fecha_entrada', 2024)
                        ->count();
                    return "La cantidad de muestras ingresadas en 2024 es $cantidad.";
                }
            ],
            'muestras_microbiologia_2024' => [
                'match' => ['cu[aá]ntas.*microbiolog', 'cantidad.*microbiolog'],
                'consulta' => function () {
                    $cantidad = DB::table('ensayo_muestra as em')
                        ->join('ensayos as e', 'em.ensayo_id', '=', 'e.id')
                        ->join('muestras as m', 'em.muestra_id', '=', 'm.id')
                        ->where('e.tipo_ensayo', 'like', '%microbiolog%')
                        ->whereYear('m.fecha_entrada', 2024)
                        ->distinct('em.muestra_id')
                        ->count('em.muestra_id');
                    return "Se encontraron $cantidad muestras de microbiología en 2024.";
                }
            ],
            // Puedes seguir agregando más intenciones específicas aquí...
        ];
    }

    public function interpretar(Request $request)
    {
        $pregunta = strtolower($request->input('pregunta', ''));

        foreach ($this->intenciones as $clave => $intencion) {
            foreach ($intencion['match'] as $patron) {
                if (preg_match("/{$patron}/i", $pregunta)) {
                    try {
                        $respuesta = call_user_func($intencion['consulta']);
                        return response()->json([
                            'intencion' => $clave,
                            'respuesta' => $respuesta,
                        ]);
                    } catch (\Exception $e) {
                        Log::error("❌ Error al ejecutar consulta para intención [$clave]: " . $e->getMessage());
                        return response()->json([
                            'error' => 'Error al ejecutar la consulta.',
                            'detalle' => $e->getMessage()
                        ], 500);
                    }
                }
            }
        }

        return response()->json(['error' => 'No se pudo interpretar la intención.'], 422);
    }
}
