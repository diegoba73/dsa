<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Stockreactivo;
use App\Reactivo;
use App\User;

class StockreactivoController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        
        $stock_reactivo = new Stockreactivo();
        $stock_reactivo->proveedor_id = $request->input('proveedor_id');
        $stock_reactivo->pedido = $request->input('pedido');
        $stock_reactivo->registro = $request->input('registro');
        $stock_reactivo->fecha_entrada = $request->input('fecha_entrada');
        $stock_reactivo->fecha_apertura = $request->input('fecha_apertura');
        $stock_reactivo->fecha_vencimiento = $request->input('fecha_vencimiento');
        $stock_reactivo->fecha_baja = $request->input('fecha_baja');
        $stock_reactivo->contenido = $request->input('contenido');
        $stock_reactivo->marca = $request->input('marca');
        $stock_reactivo->grado = $request->input('grado');
        $stock_reactivo->lote = $request->input('lote');
        $stock_reactivo->conservacion = $request->input('conservacion');
        $stock_reactivo->almacenamiento = $request->input('almacenamiento');
        $stock_reactivo->hs = $request->input('hs');
        $stock_reactivo->observaciones = $request->input('observaciones');
        $stock_reactivo->reactivo_id = $request->input('id');
        $stock_reactivo->area = $request->input('area');
        $stock_reactivo->save();
        $url = redirect()->getUrlGenerator()->previous();
        return back();  
    }

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $stock_reactivo = Stockreactivo::findOrFail($request->id);
        $stock_reactivo->area = $request->input('area');
        $stock_reactivo->update($request->all());
        $url = redirect()->getUrlGenerator()->previous();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $stock_reactivo = Stockreactivo::findOrFail($request->id);
        $stock_reactivo->delete();

        return back();

    }
}
