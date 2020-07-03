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
use App\Dsanota;
use App\User;

class DsanotaController extends Controller
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
        $dsanotas = Dsanota::orderBy('dsanotas.id', 'DESC')
                    ->numero($numero)
                    ->descripcion($descripcion)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('dsa.notas.index')->with(compact('dsanotas')); // listado notas DSO
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dsanotas = Dsanota::all();

        return view('dsa.notas.create')->with(compact('dsanotas'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dsanota = new Dsanota();
        $registros_tabla = Dsanota::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Dsanota::orderBy('id', 'desc')->first();
                $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 
                }
        $dsanota->numero = $numero_siguiente;
        $dsanota->fecha = $request->input('fecha');
        $dsanota->descripcion = $request->input('descripcion');
        $dsanota->user_id = $this->auth->user()->id;
        $dsanota->save(); // Insert nota
        $notification = 'La nota fué INGRESADA correctamente.';
        return redirect('/dsa/notas/index')->with(compact('notification'));
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
        $dsanota = Dsanota::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('dsa.notas.edit')->with(compact('dsanota', 'url'));  // editar nota    
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
        $dsanota = Dsanota::find($id);
        $dsanota->fecha = $request->input('fecha');
        $dsanota->descripcion = $request->input('descripcion');
        $dsanota->user_id = $this->auth->user()->id;
        $dsanota->save();
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
