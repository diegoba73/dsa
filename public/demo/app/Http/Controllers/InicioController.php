<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Ensayo;
 
class InicioController extends Controller
{
    public $timestamps = false;//

    public function index(Request $request)
    {
        $micro_ensayos = DB::table('ensayos')->join('matrizs', 'matrizs.id', '=', 'ensayos.matriz_id')->where('ensayos.tipo_ensayo', 'Microbiológico')->where('ensayos.activo', "=", 1)->orderBy('ensayos.id', 'DESC')->get();
        $crom_ensayos = DB::table('ensayos')->join('matrizs', 'matrizs.id', '=', 'ensayos.matriz_id')->where('ensayos.tipo_ensayo', 'Cromatografía')->where('ensayos.activo', "=", 1)->orderBy('ensayos.id', 'DESC')->get();
        $eb_ensayos = DB::table('ensayos')->join('matrizs', 'matrizs.id', '=', 'ensayos.matriz_id')->where('ensayos.tipo_ensayo', 'Ensayo Biológico')->where('ensayos.activo', "=", 1)->orderBy('ensayos.id', 'DESC')->get();
        $qag_ensayos = DB::table('ensayos')->join('matrizs', 'matrizs.id', '=', 'ensayos.matriz_id')->where([['ensayos.tipo_ensayo', 'Físico/Químico'], ['ensayos.matriz_id', '<>', '2'], ['ensayos.matriz_id', '<>', '1']])->where('ensayos.activo', "=", 1)->orderBy('ensayos.id', 'DESC')->get();
        $qal_ensayos = DB::table('ensayos')->join('matrizs', 'matrizs.id', '=', 'ensayos.matriz_id')->where([['ensayos.tipo_ensayo', 'Físico/Químico'], ['ensayos.matriz_id', '=', '1']])->orWhere([['ensayos.tipo_ensayo', 'Físico/Químico'], ['ensayos.matriz_id', '=', '2']])->where('ensayos.activo', "=", 1)->orderBy('ensayos.id', 'DESC')->get();
        $nomencladors = DB::table('nomencladors')->join('departamentos', 'departamentos.id', '=', 'nomencladors.departamento_id')->get();
        return view('inicio')->with(compact('micro_ensayos', 'crom_ensayos', 'eb_ensayos', 'qal_ensayos', 'qag_ensayos', 'nomencladors')); // Nomenclador
    }
    
}

