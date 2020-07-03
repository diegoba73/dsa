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
use App\Dbexp;
use App\User;

class DbexpController extends Controller
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
        $dbexps = Dbexp::orderBy('dbexps.id', 'DESC')
                    ->numero($numero)
                    ->descripcion($descripcion)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('db.exp.index')->with(compact('dbexps')); // listado notas db
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dbexp = Dbexp::all();

        return view('db.exp.create')->with(compact('dbexp'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dbexp = new Dbexp();
        $registros_tabla = Dbexp::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Dbexp::orderBy('id', 'desc')->first();
                $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 
                }
        $dbexp->numero = $numero_siguiente;
        $dbexp->fecha = $request->input('fecha');
        $dbexp->descripcion = $request->input('descripcion');
        $dbexp->user_id = $this->auth->user()->id;
        $dbexp->save(); // Insert nota
        $notification = 'El Expediente fué INGRESADO correctamente.';
        return redirect('/db/exp/index')->with(compact('notification'));
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
        $dbexp = Dbexp::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('db.exp.edit')->with(compact('dbexp', 'url'));  // editar exp    
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
        $dbexp = Dbexp::find($id);
        $dbexp->fecha = $request->input('fecha');
        $dbexp->descripcion = $request->input('descripcion');
        $dbexp->user_id = $this->auth->user()->id;
        $dbexp->save();
        $url = Input::get('url');
        $notification = 'El Expediente fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));
    }

}
