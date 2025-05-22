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
use App\Dbarchivo;
use App\User;

class DbarchivoController extends Controller
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
        $caja       = $request->get('caja');
        $establecimiento = $request->get('establecimiento');
        $descripcion = $request->get('descripcion');
        $dbarchivos = Dbarchivo::orderBy('dbarchivos.id', 'DESC')
                    ->caja($caja)
                    ->establecimiento($establecimiento)
                    ->descripcion($descripcion)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('db.archivo.index')->with(compact('dbarchivos')); // listado archivos db
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dbarchivos = Dbarchivo::all();

        return view('db.archivo.create')->with(compact('dbarchivos'));  // formulario archivo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dbarchivo = new Dbarchivo();
        $dbarchivo->caja = $request->input('caja');
        $dbarchivo->establecimiento = $request->input('establecimiento');
        $dbarchivo->descripcion = $request->input('descripcion');
        $dbarchivo->user_id = $this->auth->user()->id;
        $dbarchivo->save(); // Insert archivo
        $notification = 'El Archivo fué INGRESADO correctamente.';
        return redirect('/db/archivo/index')->with(compact('notification'));
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
        $dbarchivo = Dbarchivo::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('db.archivo.edit')->with(compact('dbarchivo', 'url'));  // editar archivo    
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
        $dbarchivo = Dbarchivo::find($id);
        $dbarchivo->caja = $request->input('caja');
        $dbarchivo->establecimiento = $request->input('establecimiento');
        $dbarchivo->descripcion = $request->input('descripcion');
        $dbarchivo->user_id = $this->auth->user()->id;
        $dbarchivo->save();
        $url = Input::get('url');
        $notification = 'El Archivo fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));
    }

}
