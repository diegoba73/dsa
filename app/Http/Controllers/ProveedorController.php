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
use App\Proveedor;

class ProveedorController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $proveedors = Proveedor::orderBy('proveedors.id', 'DESC')->paginate(20);
        return view('admin.proveedores.index')->with(compact('proveedors')); // listado proveedores
    }

    public function create()
    {
        $proveedors = Proveedor::all();
        return view('admin.proveedores.create')->with(compact('proveedors'));  // formulario remito
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->empresa = $request->input('empresa');
        $proveedor->contacto = $request->input('contacto');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->email = $request->input('email');
        $proveedor->tipo_insumo = $request->input('tipo_insumo');
        $proveedor->criticidad = $request->input('criticidad');
        $proveedor->save(); // Insert remito
        $notification = 'El Proveedor fué INGRESADO correctamente.';
        return redirect('/admin/proveedores/index')->with(compact('notification'));
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
        $proveedor = Proveedor::find($id);
        return view('admin.proveedores.edit')->with(compact('proveedor'));  // editar remito    
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
        $proveedor = Proveedor::find($id);
        $proveedor->empresa = $request->input('empresa');
        $proveedor->contacto = $request->input('contacto');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->email = $request->input('email');
        $proveedor->tipo_insumo = $request->input('tipo_insumo');
        $proveedor->criticidad = $request->input('criticidad');
        $proveedor->save(); // Insert remito
        $notification = 'El Proveedor fué ACTUALIZADO correctamente.';
        return redirect()->route('proveedores_index', array('id' => $id))->with(compact('notification'));

    }
}
