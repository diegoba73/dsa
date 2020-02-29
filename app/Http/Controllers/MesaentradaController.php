<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Mesaentrada;
use App\Departamento;

class MesaentradaController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha_ingreso       = $request->get('fecha_ingreso');
        $descripcion = $request->get('descripcion');
        $destino = $request->get('destino');
        $nro_nota_remitida = $request->get('nro_nota_remitida');
        $mesaentradas = Mesaentrada::orderBy('mesaentradas.id', 'DESC')
                    ->fecha($fecha_ingreso)
                    ->descripcion($descripcion)
                    ->destino($destino)
                    ->nota($nro_nota_remitida)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('db.mesaentrada.index')->with(compact('mesaentradas')); // listado notas db
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mesaentrada = Mesaentrada::all();

        return view('db.mesaentrada.create')->with(compact('mesaentrada'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mesaentrada = new Mesaentrada();
        $mesaentrada->departamento_id = $this->auth->user()->departamento_id;
        $mesaentrada->fecha_ingreso = $request->input('fecha_ingreso');
        $mesaentrada->descripcion = $request->input('descripcion');
        $mesaentrada->destino = $request->input('destino');
        $mesaentrada->nro_nota_remitida = $request->input('nro_nota_remitida');
        $mesaentrada->usuario = $this->auth->user()->usuario;
        $mesaentrada->save(); // Insert ingreso
        $notification = 'Se hizo el INGRESO correctamente.';
        return redirect('/db/mesaentrada/index')->with(compact('notification'));
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
        $mesaentrada = Mesaentrada::find($id);
        return view('db.mesaentrada.edit')->with(compact('mesaentrada'));  // editar nota    
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
        $mesaentrada = Mesaentrada::find($id);
        $mesaentrada->departamento_id = $this->auth->user()->departamento_id;
        $mesaentrada->fecha_ingreso = $request->input('fecha_ingreso');
        $mesaentrada->descripcion = $request->input('descripcion');
        $mesaentrada->destino = $request->input('destino');
        $mesaentrada->nro_nota_remitida = $request->input('nro_nota_remitida');
        $mesaentrada->nro_nota_respuesta = $request->input('nro_nota_respuesta');
        $mesaentrada->usuario = $this->auth->user()->usuario;
        $mesaentrada->finalizado = $request->input('finalizado');
        $mesaentrada->save();
        $notification = 'El ingreso fué ACTUALIZADO correctamente.';
        return redirect('/db/mesaentrada/index')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function finalizar (Request $request, $id)
    {
        $mesaentrada = Mesaentrada::findOrFail($id);
        $mesaentrada->finalizado = '1';
        $mesaentrada->save();
        $notification = 'La muestra fué FINALIZADA correctamente.';
        return back()->with(compact('notification'));
    }
}
