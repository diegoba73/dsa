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
use App\Dbnota;
use App\Dsbnota;
use App\Dsonota;
use App\Dsbremito;
use App\User;

class DbnotaController extends Controller
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
        $numero       = $request->get('numero');
        $descripcion = $request->get('descripcion');
        $dbnotas = Dbnota::orderBy('dbnotas.id', 'DESC')
                    ->numero($numero)
                    ->descripcion($descripcion)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('db.notas.index')->with(compact('dbnotas')); // listado notas db
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dbnotas = Dbnota::all();

        return view('db.notas.create')->with(compact('dbnotas'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dbnota = new Dbnota();
        $registros_tabla = Dbnota::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Dbnota::orderBy('id', 'desc')->first();
                $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 
                }
        $dbnota->numero = $numero_siguiente;
        $dbnota->fecha = $request->input('fecha');
        $dbnota->descripcion = $request->input('descripcion');
        $dbnota->user_id = $this->auth->user()->id;
        $dbnota->save(); // Insert nota
        $notification = 'La nota fué INGRESADA correctamente.';
        return redirect('/notas/index')->with(compact('notification'));
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
        $dbnota = Dbnota::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('db.notas.edit')->with(compact('dbnota', 'url'));  // editar nota    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dbnota = Dbnota::find($id);
        $dbnota->fecha = $request->input('fecha');
        $dbnota->descripcion = $request->input('descripcion');
        $dbnota->user_id = $this->auth->user()->id;
        $dbnota->save();
        $url = Input::get('url');
        $notification = 'La nota fué ACTUALIZADA correctamente.';
        return redirect($url)->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function notaremito(Request $request)
    {
        
        if (Auth::user()->departamento_id == 2) {
            $dbnota = new Dbnota();
            $registros_tabla = Dbnota::count();
                    if ($registros_tabla == 0){
                        $numero_siguiente = 1; 
                    }
                    else {
                    $ultimo_registro = Dbnota::orderBy('id', 'desc')->first();
                    $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                    $ano_actual = Carbon::now()->year;
                    
                    if ( $ultimo_ano == $ano_actual)
                    { $numero_siguiente = $ultimo_registro->numero+1;
                    } 
                    else {
                    $numero_siguiente = 1; } 
                    }
            $dbnota->numero = $numero_siguiente;
            $dbnota->fecha = $request->input('fecha');
            $dbnota->descripcion = $request->input('descripcion');
            $dbnota->user_id = $this->auth->user()->id;
            $dbnota->save(); // Insert nota
            $nronota = Dbnota::orderBy('id', 'desc')->first();
            $notification = 'La nota fué INGRESADA correctamente. Nº de Nota: '. $nronota->numero;
            return back()->withInput()->with(compact('notification'));
        } elseif (Auth::user()->departamento_id == 3) {
            $dsbnota = new Dsbnota();
            $registros_tabla = Dsbnota::count();
                    if ($registros_tabla == 0){
                        $numero_siguiente = 1; 
                    }
                    else {
                    $ultimo_registro = Dsbnota::orderBy('id', 'desc')->first();
                    $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                    $ano_actual = Carbon::now()->year;
                    
                    if ( $ultimo_ano == $ano_actual)
                    { $numero_siguiente = $ultimo_registro->numero+1;
                    } 
                    else {
                    $numero_siguiente = 1; } 
                    }
            $dsbnota->numero = $numero_siguiente;
            $dsbnota->fecha = $request->input('fecha');
            $dsbnota->descripcion = $request->input('descripcion');
            $dsbnota->user_id = $this->auth->user()->id;
            $dsbnota->save(); // Insert nota
            $nronota = Dsbnota::orderBy('id', 'desc')->first();
            $notification = 'La nota fué INGRESADA correctamente. Nº de Nota: '. $nronota->numero;
            return back()->withInput()->with(compact('notification'));
        } elseif (Auth::user()->departamento_id == 4) {
            $dsonota = new Dsonota();
            $registros_tabla = Dsonota::count();
                    if ($registros_tabla == 0){
                        $numero_siguiente = 1; 
                    }
                    else {
                    $ultimo_registro = Dsonota::orderBy('id', 'desc')->first();
                    $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                    $ano_actual = Carbon::now()->year;
                    
                    if ( $ultimo_ano == $ano_actual)
                    { $numero_siguiente = $ultimo_registro->numero+1;
                    } 
                    else {
                    $numero_siguiente = 1; } 
                    }
            $dsonota->numero = $numero_siguiente;
            $dsonota->fecha = $request->input('fecha');
            $dsonota->descripcion = $request->input('descripcion');
            $dsonota->user_id = $this->auth->user()->id;
            $dsonota->save(); // Insert nota
            $nronota = Dsonota::orderBy('id', 'desc')->first();
            $notification = 'La nota fué INGRESADA correctamente. Nº de Nota: '. $nronota->numero;
            return back()->withInput()->with(compact('notification'));
        } 
    }

}
