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
use App\Dbremito;
use App\Muestra;
use App\Tipomuestra;
use App\Remitente;
use App\Localidad;
use App\Provincia;
use App\User;
use \PDF;

class DbremitoController extends Controller
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
        $db_remitos = Dbremito::orderBy('dbremitos.id', 'DESC')
                    ->nro_nota($nro_nota)
                    ->conclusion($conclusion)
                    ->remite($remitente)
                    ->paginate(20);
        $remitentes = Remitente::all();
        return view('db.remitos.index')->with(compact('db_remitos', 'remitentes')); // listado remitos db
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $db_remitos = Dbremito::all();
        $muestras = Muestra::where('departamento_id', 2)->where('cargada', 1)->where('aceptada', 1)->where('remitir', null)->get();
        $remitentes = Remitente::all();

        return view('db.remitos.create')->with(compact('db_remitos', 'muestras', 'remitentes'));  // formulario remito
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
        $db_remito = new Dbremito();
        $db_remito->remitente_id = $request->input('remitente');
        $db_remito->fecha = $request->input('fecha');
        $db_remito->nro_nota = $request->input('nro_nota');
        $db_remito->conclusion = $request->input('conclusion');
        $db_remito->user_id = $this->auth->user()->id;
        $db_remito->save(); // Insert remito
        $muestras = Input::get('muestras');
        $db_remito->muestras()->sync($muestras);
        foreach ($muestras as $muestra) {
            $muestra = Muestra::find($muestra);
            $muestra->remitir = '1';
            $muestra->save();
        }
        $notification = 'El remito fué INGRESADO correctamente.';
        return redirect()->route('db_remitos_index')->with(compact('notification'));
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
        $db_remito = Dbremito::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        $remitentes = Remitente::all();
        $muestras = Muestra::where('departamento_id', 2)->where('cargada', 1)->where('aceptada', 1)->get();
        $selects = DB::table('dbremito_muestra')->where('dbremito_id', $id)->get();
        return view('db.remitos.edit')->with(compact('db_remito', 'url', 'selects', 'muestras', 'remitentes'));  // editar remito    
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
        $db_remito = Dbremito::find($id);
        $db_remito->remitente_id = $request->input('remitente');
        $db_remito->fecha = $request->input('fecha');
        $db_remito->nro_nota = $request->input('nro_nota');
        $db_remito->conclusion = $request->input('conclusion');
        $db_remito->save();
        $url = Input::get('url');
        $muestras = Input::get('muestras');
        $db_remito->muestras()->sync($muestras);
        foreach ($muestras as $muestra) {
            $muestra = Muestra::find($muestra);
            $muestra->remitir = '1';
            $muestra->save();
        }
        $notification = 'El remito fué ACTUALIZADO correctamente.';
        return redirect()->route('db_remitos_index', array('id' => $id))->with(compact('notification'));

    }

    public function imprimir_remito($id)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        $db_remito = Dbremito::find($id);
        $db_remito_muestra = DB::table('dbremito_muestra')->where('dbremito_id', $id)->first();
        $remitente = Remitente::all();
        $tipomuestra = Tipomuestra::all();
        $muestras = Muestra::where('departamento_id', 2)->where('cargada', 1)->where('aceptada', 1)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('db.remitos.imprimir_remito')->with(compact('db_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }

    public function aceptar (Request $request, $id)
    {
        $db_remito = Dbremito::findOrFail($id);
        $db_remito->chequeado = '1';
        $db_remito->save();
        $notification = 'El Remito fué ACEPTADO correctamente.';
        return back()->with(compact('notification'));
    }
    public function rechazar (Request $request, $id)
    {
        $db_remito = Dbremito::findOrFail($id);
        $db_remito->chequeado = '0';
        $db_remito->save();
        $notification = 'El Remito fué Rechazado correctamente.';
        return back()->with(compact('notification'));
    }

    public function imprimir_remito_firma($id)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $mes = $meses[($fecha->format('n')) - 1];
        $fecha_hoy = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        $db_remito = Dbremito::find($id);
        $db_remito_muestra = DB::table('dbremito_muestra')->where('dbremito_id', $id)->first();
        $remitente = Remitente::all();
        $muestras = Muestra::where('departamento_id', 2)->where('cargada', 1)->where('aceptada', 1)->where('remitir', 0 || null)->get();
        $localidad = Localidad::all();
        $provincia = Provincia::all();
        return view('db.remitos.imprimir_remito_firma')->with(compact('db_remito', 'remitente', 'localidad', 'provincia', 'muestras', 'fecha_hoy'));
    }
}
