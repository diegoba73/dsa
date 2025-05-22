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
use App\Dsbremito;
use App\Muestra;
use App\Remitente;
use App\Localidad;
use App\Provincia;
use App\User;
use \PDF;

class DsbremitoController extends Controller
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
        $dsb_remitos = Dsbremito::orderBy('dsbremitos.id', 'DESC')
                    ->nro_nota($nro_nota)
                    ->conclusion($conclusion)
                    ->remite($remitente)
                    ->paginate(20);
        $remitentes = Remitente::all();
        return view('dsb.remitos.index')->with(compact('dsb_remitos', 'remitentes')); // listado remitos dsb
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dsb_remitos = Dsbremito::all();
        $muestras = Muestra::where('departamento_id', 3)->where('cargada', 1)->where('aceptada', 1)->where('remitir', null)->get();
        $remitentes = Remitente::all();

        return view('dsb.remitos.create')->with(compact('dsb_remitos', 'muestras', 'remitentes'));  // formulario remito
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
        $dsb_remito = new Dsbremito();
        $dsb_remito->remitente_id = $request->input('remitente');
        $dsb_remito->fecha = $request->input('fecha');
        $dsb_remito->nro_nota = $request->input('nro_nota');
        $dsb_remito->conclusion = $request->input('conclusion');
        $dsb_remito->user_id = $this->auth->user()->id;
        $dsb_remito->save(); // Insert remito
        $muestras = Input::get('muestras');
        $dsb_remito->muestras()->sync($muestras);
        foreach ($muestras as $muestra) {
            $muestra = Muestra::find($muestra);
            $muestra->remitir = '1';
            $muestra->save();
        }
        $notification = 'El remito fué INGRESADO correctamente.';
        return redirect('/dsb/remitos/index')->with(compact('notification'));
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
        $dsb_remito = Dsbremito::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        $remitentes = Remitente::all();
        $muestras = Muestra::where('departamento_id', 3)->where('cargada', 1)->where('aceptada', 1)->get();
        $selects = DB::table('dsbremito_muestra')->where('dsbremito_id', $id)->get();
        return view('dsb.remitos.edit')->with(compact('dsb_remito', 'url', 'selects', 'muestras', 'remitentes'));  // editar remito    
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
        $dsb_remito = Dsbremito::find($id);
        $dsb_remito->remitente_id = $request->input('remitente');
        $dsb_remito->fecha = $request->input('fecha');
        $dsb_remito->nro_nota = $request->input('nro_nota');
        $dsb_remito->conclusion = $request->input('conclusion');
        $dsb_remito->save();
        $url = Input::get('url');
        $muestras = Input::get('muestras');
        $dsb_remito->muestras()->sync($muestras);
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
        $dsb_remito = Dsbremito::find($id);
        $dsb_remito_muestra = DB::table('dsbremito_muestra')->where('dsbremito_id', $id)->first();
        $remitente = Remitente::all();
        $muestras = Muestra::where('departamento_id', 3)->where('cargada', 1)->where('aceptada', 1)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('dsb.remitos.imprimir_remito')->with(compact('dsb_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }

    public function aceptar (Request $request, $id)
    {
        $dsb_remito = Dsbremito::findOrFail($id);
        $dsb_remito->chequeado = '1';
        $dsb_remito->save();
        $notification = 'El Remito fué ACEPTADO correctamente.';
        return back()->with(compact('notification'));
    }
    public function rechazar (Request $request, $id)
    {
        $dsb_remito = Dsbremito::findOrFail($id);
        $dsb_remito->chequeado = '0';
        $dsb_remito->save();
        $notification = 'El Remito fué Rechazado correctamente.';
        return back()->with(compact('notification'));
    }
    
    public function imprimir_remito_firma($id)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        $dsb_remito = Dsbremito::find($id);
        $dsb_remito_muestra = DB::table('dsbremito_muestra')->where('dsbremito_id', $id)->first();
        $remitente = Remitente::all();
        $muestras = Muestra::where('departamento_id', 3)->where('cargada', 1)->where('aceptada', 1)->where('remitir', 0 || null)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('dsb.remitos.imprimir_remito_firma')->with(compact('dsb_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }
}
