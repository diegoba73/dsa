<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ValidarRemitoRequest;
use Carbon\Carbon;
use App\Dsoremito;
use App\Muestra;
use App\Remitente;
use App\Localidad;
use App\Provincia;
use App\User;
use \PDF;

class DsoremitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $nro_nota       = $request->get('nro_nota');
        $conclusion = $request->get('conclusion');
        $remitente      = $request->get('remitente');
        $dso_remitos = Dsoremito::orderBy('dsoremitos.id', 'DESC')
                    ->nro_nota($nro_nota)
                    ->conclusion($conclusion)
                    ->remite($remitente)
                    ->paginate(20);
        $remitentes = Remitente::all();
        return view('dso.remitos.index')->with(compact('dso_remitos', 'remitentes')); // listado remitos dso
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dso_remitos = Dsoremito::all();
        $muestras = Muestra::where('departamento_id', 4)->where('cargada', 1)->where('aceptada', 1)->where('remitir', null)->get();
        $remitentes = Remitente::all();

        return view('dso.remitos.create')->with(compact('dso_remitos', 'muestras', 'remitentes'));  // formulario remito
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidarRemitoRequest $request)
    {
        $validated = $request->validated();
        $dso_remito = new Dsoremito();
        $dso_remito->remitente_id = $request->input('remitente');
        $dso_remito->fecha = $request->input('fecha');
        $dso_remito->nro_nota = $request->input('nro_nota');
        $dso_remito->conclusion = $request->input('conclusion');
        $dso_remito->user_id = $this->auth->user()->id;
        $dso_remito->save(); // Insert remito
        $muestras = Input::get('muestras');
        $dso_remito->muestras()->sync($muestras);
        foreach ($muestras as $muestra) {
            $muestra = Muestra::find($muestra);
            $muestra->remitir = '1';
            $muestra->save();
        }
        $notification = 'El remito fué INGRESADO correctamente.';
        return redirect('/dso/remitos/index')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dso_remito = Dsoremito::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        $remitentes = Remitente::all();
        $muestras = Muestra::where('departamento_id', 4)->where('cargada', 1)->where('aceptada', 1)->where('remitir', 1)->get();
        $selects = DB::table('dsoremito_muestra')->where('dsoremito_id', $id)->get();
        return view('dso.remitos.edit')->with(compact('dso_remito', 'url', 'selects', 'muestras', 'remitentes'));  // editar remito    
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidarRemitoRequest $request, $id)
    {
        $validated = $request->validated();
        $dso_remito = Dsoremito::find($id);
        $dso_remito->remitente_id = $request->input('remitente');
        $dso_remito->fecha = $request->input('fecha');
        $dso_remito->nro_nota = $request->input('nro_nota');
        $dso_remito->conclusion = $request->input('conclusion');
        $dso_remito->fecha_salida = $request->input('fecha_salida');
        $dso_remito->save();
        $url = Input::get('url');
        $muestras = Input::get('muestras');
        $dso_remito->muestras()->sync($muestras);
        foreach ($muestras as $muestra) {
            $muestra = Muestra::find($muestra);
            $muestra->remitir = '1';
            $muestra->save();
        }
        $notification = 'El remito fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));

    }

    public function imprimir_remito($id)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        $dso_remito = Dsoremito::find($id);
        $dso_remito_muestra = DB::table('dsoremito_muestra')->where('dsoremito_id', $id)->first();
        $remitente = Remitente::all();
        $muestras = Muestra::where('departamento_id', 4)->where('cargada', 1)->where('aceptada', 1)->where('remitir', 0 || null)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('dso.remitos.imprimir_remito')->with(compact('dso_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }
    
    public function imprimir_remito_firma($id)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        $dso_remito = Dsoremito::find($id);
        $dso_remito_muestra = DB::table('dsoremito_muestra')->where('dsoremito_id', $id)->first();
        $remitente = Remitente::all();
        $muestras = Muestra::where('departamento_id', 4)->where('cargada', 1)->where('aceptada', 1)->where('remitir', 0 || null)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('dso.remitos.imprimir_remito_firma')->with(compact('dso_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }
}
