<?php

namespace App\Http\Controllers;

use App\Remitente;
use App\User;
use App\Muestra;
use App\Matriz;
use App\Tipomuestra;
use App\Localidad;
use App\Provincia;
use App\Departamento;
use App\Ensayo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\CondicionExport;
use App\Exports\CondicionDbExport;
use App\Exports\TipoMuestraExport;
use App\Exports\TipoEnsayoExport;
use Maatwebsite\Excel\Facades\Excel;


class AnuarioController extends Controller
{

    public function consulta()
    {
        $year = date('Y');
        $departamentos = Departamento::all();
        return view('admin.anuario.consulta', compact('departamentos', 'year'));
    }

    public function resultados(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $muestras = Muestra::with('departamento')
        ->whereYear('fecha_entrada', $year)
        ->get();
        $muestrasMicrobiologia = Muestra::whereHas('ensayos', function ($query) {
                                    $query->where('tipo_ensayo', 'Microbiologico');
                                })->whereYear('fecha_entrada', $year)
                                ->distinct()
                                ->count();
    
        $muestrasQuimicaAlimentos = Muestra::whereHas('ensayos', function ($query) {
                                        $query->where('tipo_ensayo', 'Físico/Químico');
                                    })->whereYear('fecha_entrada', $year)
                                    ->whereIn('matriz_id', [1, 2])
                                    ->distinct()
                                    ->count();
        $muestrasQuimicaAgua = Muestra::whereHas('ensayos', function ($query) {
                                    $query->where('tipo_ensayo', 'Físico/Químico')
                                            ->orWhere('tipo_ensayo', 'Fisicoqímico');
                                })->whereYear('fecha_entrada', $year)
                                ->whereIn('matriz_id', [3, 4, 5, 9, 10, 11, 12, 13, 14, 15])
                                ->distinct()
                                ->count();
        $muestrasEnsayoBiologico = Muestra::whereHas('ensayos', function ($query) {
                                        $query->where('tipo_ensayo', 'Ensayo Biológico')
                                            ->orWhere('tipo_ensayo', 'Bioensayo');
                                    })->whereYear('fecha_entrada', $year)
                                    ->distinct()
                                    ->count();
        $muestrasCromatografia = Muestra::whereHas('ensayos', function ($query) {
                                    $query->where('tipo_ensayo', 'Cromatografía');
                                })->whereYear('fecha_entrada', $year)
                                ->distinct()
                                ->count();
    
        $ensayos = Ensayo::join('ensayo_muestra', 'ensayos.id', '=', 'ensayo_muestra.ensayo_id')
                            ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                            ->whereYear('muestras.fecha_entrada', $year)
                            ->select('ensayos.tipo_ensayo', DB::raw('count(*) as total'))
                            ->groupBy('ensayos.tipo_ensayo')
                            ->get();

        $matrizs = Ensayo::join('ensayo_muestra', 'ensayos.id', '=', 'ensayo_muestra.ensayo_id')
                            ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                            ->join('matrizs', 'muestras.matriz_id', '=', 'matrizs.id')
                            ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                            ->whereYear('muestras.fecha_entrada', $year)
                            ->select('ensayos.tipo_ensayo', 'matrizs.matriz as matriz', 'departamentos.departamento as departamento', DB::raw('count(*) as total'))
                            ->groupBy('matrizs.matriz', 'departamentos.departamento', 'ensayos.tipo_ensayo')
                            ->orderBy('departamentos.departamento', 'asc')
                            ->orderBy('matrizs.matriz', 'asc')
                            ->get();
    
        
        $tiposPrestaciones = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->select('departamentos.departamento as departamento', 'muestras.tipo_prestacion', DB::raw('COUNT(*) as total'))
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('tipo_prestacion')
                                    ->get();

        $tiposPrestacionesDpto = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->select('departamentos.departamento as departamento', 'muestras.tipo_prestacion', DB::raw('COUNT(*) as total'))
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('tipo_prestacion')
                                    ->groupBy('departamento')
                                    ->orderBy('departamentos.departamento')
                                    ->get();
                    
        $matriz_t = Muestra::join('matrizs', 'muestras.matriz_id', '=', 'matrizs.id')
                            ->select('matrizs.matriz', DB::raw('count(*) as total'), DB::raw('count(*) / (select count(*) from muestras where year(fecha_entrada) = '.$year.') * 100 as porcentaje'))
                            ->whereYear('fecha_entrada', $year)
                            ->groupBy('matrizs.matriz')
                            ->orderBy('porcentaje', 'DESC')
                            ->get();

 
        $matriz_dpto = Muestra::join('matrizs', 'muestras.matriz_id', '=', 'matrizs.id')
                                ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                ->select('matrizs.matriz', 'departamentos.departamento as departamento', DB::raw('count(*) as total'))
                                ->whereYear('fecha_entrada', $year)
                                ->groupBy('matrizs.matriz', 'departamentos.departamento')
                                ->orderBy('departamentos.departamento', 'asc')
                                ->orderBy('matriz', 'ASC')
                                ->get();

        $tiposMuestra = Muestra::join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                ->select('tipomuestras.tipo_muestra', 'departamentos.departamento as departamento', DB::raw('count(*) as total'))
                                ->whereYear('fecha_entrada', $year)
                                ->groupBy('tipomuestras.tipo_muestra', 'departamentos.departamento')
                                ->orderBy('departamentos.departamento', 'asc')
                                ->orderBy('tipo_muestra', 'ASC')
                                ->get();
        
        // Consulta para obtener las muestras por departamento
        $muestras_por_departamento = Muestra::selectRaw('departamentos.departamento AS departamento, COUNT(*) AS cantidad')
                                    ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('departamento')
                                    ->get();

        $condicionesdb = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                    ->select('departamentos.departamento as departamento', 'tipomuestras.tipo_muestra as tipomuestra', 'muestras.condicion', 'muestras.microbiologia', 'muestras.quimica', DB::raw('(CASE WHEN muestras.microbiologia THEN "microbiologico" WHEN muestras.quimica THEN "fisico/quimica" ELSE "" END) AS tipo'), DB::raw('COUNT(*) as total'))
                                    ->where('departamento_id', 2)
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('muestras.condicion', 'tipomuestras.tipo_muestra')
                                    ->get();
        $condicionesdsb = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                    ->select('departamentos.departamento as departamento', 'tipomuestras.tipo_muestra as tipomuestra', 'muestras.condicion', 'muestras.microbiologia', 'muestras.quimica', DB::raw('(CASE WHEN muestras.microbiologia THEN "microbiologico" WHEN muestras.quimica THEN "fisico/quimica" ELSE "" END) AS tipo'), DB::raw('COUNT(*) as total'))
                                    ->where('departamento_id', 3)
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('muestras.condicion', 'tipomuestras.tipo_muestra')
                                    ->get();
        $condicionesdso = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                    ->select('departamentos.departamento as departamento', 'tipomuestras.tipo_muestra as tipomuestra', 'muestras.condicion', 'muestras.microbiologia', 'muestras.quimica', DB::raw('(CASE WHEN muestras.microbiologia THEN "microbiologico" WHEN muestras.quimica THEN "fisico/quimica" ELSE "" END) AS tipo'), DB::raw('COUNT(*) as total'))
                                    ->where('departamento_id', 4)
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('muestras.condicion', 'tipomuestras.tipo_muestra')
                                    ->get();

        $muestras_prov = DB::table('muestras')
                                ->selectRaw('COUNT(*) as total_muestras, 
                                 SUM(CASE WHEN provincia_id = 7 THEN 1 ELSE 0 END) as muestras_prov, 
                                 SUM(CASE WHEN provincia_id <> 7 THEN 1 ELSE 0 END) as muestras_extraprov')
                                ->whereYear('fecha_entrada', $year)
                                ->where('departamento_id', 2)
                                ->first();
        
        $mrmayor = DB::table('ensayo_muestra')
                        ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                        ->whereYear('muestras.fecha_entrada', $year)
                        ->whereIn('ensayo_id', [285, 310, 338])
                        ->where('resultado', '>=', 400)
                        ->count('resultado');
                
        $mrmenor = DB::table('ensayo_muestra')
                        ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                        ->whereYear('muestras.fecha_entrada', $year)
                        ->whereIn('ensayo_id', [285, 310, 338])
                        ->where(function($query) {
                            $query->whereIn('resultado', ['ND'])
                                ->orWhere('resultado', '<', 400);
                        })
                        ->count('resultado');

        $diarreica_pos = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->where('ensayo_id', 286)
                    ->where('resultado', 'LIKE', '%pos%')
                    ->count();
        
        $diarreica_neg = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->where('ensayo_id', 286)
                    ->where('resultado', 'LIKE', '%neg%')
                    ->count();

        $diarreica_tot = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->where('ensayo_id', 286)
                    ->count();

        $diarreica_int = $diarreica_tot - ($diarreica_neg + $diarreica_pos);

        $amnesica_pos = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->whereIn('ensayo_id', [251, 252, 358])
                    ->where('resultado', '>', 20)
                    ->count();
        
        $amnesica_neg = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->whereIn('ensayo_id', [251, 252, 358])
                    ->where(function($query) {
                        $query->whereIn('resultado', ['ND'])
                            ->orWhere('resultado', '<', 20);
                    })
                    ->count();

        $triq_pos = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->where('ensayo_id', 287)
                    ->where('resultado', 'LIKE', 'POSITIVO')
                    ->count();
        
        $triq_neg = DB::table('ensayo_muestra')
                    ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                    ->whereYear('muestras.fecha_entrada', $year)
                    ->where('ensayo_id', 287)
                    ->where('resultado', 'LIKE', 'NEGATIVO')
                    ->count();                    

        return view('admin.anuario.resultados', compact(
            'year',
            'muestras',
            'muestrasMicrobiologia',
            'muestrasQuimicaAlimentos',
            'muestrasQuimicaAgua',
            'muestrasEnsayoBiologico',
            'muestrasCromatografia',
            'ensayos',
            'matrizs',
            'tiposPrestaciones',
            'tiposPrestacionesDpto',
            'tiposMuestra',
            'muestras_por_departamento',
            'condicionesdb',
            'condicionesdsb',
            'condicionesdso',
            'mrmayor',
            'mrmenor',
            'muestras_prov',
            'diarreica_pos',
            'diarreica_neg',
            'diarreica_int',
            'amnesica_pos',
            'amnesica_neg',
            'triq_neg',
            'triq_pos',
            'matriz_t',
            'matriz_dpto'
        ));
    }


    public function exportCondicion(Request $request)
    {
        $year = $request->input('year');
        $condiciones = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                    ->select('departamentos.departamento as departamento', 'tipomuestras.tipo_muestra as tipomuestra', 'muestras.condicion', DB::raw('(CASE WHEN muestras.microbiologia THEN "microbiologico" WHEN muestras.quimica THEN "fisico/quimica" ELSE "" END) AS tipo'), DB::raw('COUNT(*) as total'))
                                    ->whereIn('departamento_id', [2, 3, 4])
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('departamentos.departamento', 'muestras.condicion', 'tipomuestras.tipo_muestra')
                                    ->orderBy('departamentos.departamento')
                                    ->get();
    $export = new CondicionExport($condiciones);
    return Excel::download($export, 'condiciones.xlsx');
    }

    public function exportCondiciondb(Request $request)
    {
        $year = $request->input('year');
        $condicionesdb = Muestra::join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                                    ->join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                                    ->select('departamentos.departamento as departamento', 'tipomuestras.tipo_muestra as tipomuestra', 'muestras.condicion', DB::raw('(CASE WHEN muestras.microbiologia THEN "microbiologico" WHEN muestras.quimica THEN "fisico/quimica" ELSE "" END) AS tipo'), DB::raw('COUNT(*) as total'))
                                    ->whereIn('departamento_id', [2])
                                    ->whereYear('fecha_entrada', $year)
                                    ->groupBy('departamentos.departamento', 'muestras.condicion', 'tipomuestras.tipo_muestra')
                                    ->orderBy('departamentos.departamento')
                                    ->get();
    $export = new CondicionDbExport($condicionesdb);
    return Excel::download($export, 'condicionesdb.xlsx');
    }

    public function exportTipoMuestra (Request $request)
    {
        $year = $request->input('year');
        $tiposMuestra = Muestra::join('tipomuestras', 'muestras.tipomuestra_id', '=', 'tipomuestras.id')
                        ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                        ->select('tipomuestras.tipo_muestra', 'departamentos.departamento as departamento', DB::raw('count(*) as total'))
                        ->whereYear('fecha_entrada', $year)
                        ->groupBy('tipomuestras.tipo_muestra', 'departamentos.departamento')
                        ->orderBy('departamentos.departamento', 'asc')
                        ->orderBy('tipo_muestra', 'ASC')
                        ->get();
    $export = new TipoMuestraExport($tiposMuestra);
    return Excel::download($export, 'tipo_muestra.xlsx');
    }

    public function exportTipoEnsayo (Request $request)
    {
        $year = $request->input('year');
        $tipoEnsayo = Ensayo::join('ensayo_muestra', 'ensayos.id', '=', 'ensayo_muestra.ensayo_id')
                        ->join('muestras', 'ensayo_muestra.muestra_id', '=', 'muestras.id')
                        ->join('matrizs', 'muestras.matriz_id', '=', 'matrizs.id')
                        ->join('departamentos', 'muestras.departamento_id', '=', 'departamentos.id')
                        ->whereYear('muestras.fecha_entrada', $year)
                        ->select('departamentos.departamento as departamento', 'matrizs.matriz as matriz', 'ensayos.tipo_ensayo', DB::raw('count(*) as total'))
                        ->groupBy('matrizs.matriz', 'departamentos.departamento', 'ensayos.tipo_ensayo')
                        ->orderBy('departamentos.departamento', 'asc')
                        ->orderBy('matrizs.matriz', 'asc')
                        ->get();
    $export = new TipoEnsayoExport($tipoEnsayo);
    return Excel::download($export, 'tipo_ensayo.xlsx');
    }
    
}
