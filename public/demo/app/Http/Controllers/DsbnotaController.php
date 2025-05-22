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
use App\Dsbnota;
use App\User;

class DsbnotaController extends Controller
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
        $dsbnotas = Dsbnota::orderBy('dsbnotas.id', 'DESC')
                    ->numero($numero)
                    ->descripcion($descripcion)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('dsb.notas.index')->with(compact('dsbnotas')); // listado notas DSO
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dsbnotas = Dsbnota::all();

        return view('dsb.notas.create')->with(compact('dsbnotas'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $notification = 'La nota fué INGRESADA correctamente.';
        return redirect('/dsb/notas/index')->with(compact('notification'));
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
        $dsbnota = Dsbnota::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('dsb.notas.edit')->with(compact('dsbnota', 'url'));  // editar nota    
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
        $dsbnota = Dsbnota::find($id);
        $dsbnota->fecha = $request->input('fecha');
        $dsbnota->descripcion = $request->input('descripcion');
        $dsbnota->user_id = $this->auth->user()->id;
        $dsbnota->save();
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

}
