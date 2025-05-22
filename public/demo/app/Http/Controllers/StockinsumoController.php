<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Stockinsumo;
use App\Insumo;

class StockinsumoController extends Controller
{
    public function store(Request $request)
    {
        
        $stock_insumo = new Stockinsumo();
        $stock_insumo->proveedor_id = $request->input('proveedor_id');
        $stock_insumo->pedido = $request->input('pedido');
        $stock_insumo->registro = $request->input('registro');
        $stock_insumo->fecha_entrada = $request->input('fecha_entrada');
        $stock_insumo->fecha_baja = $request->input('fecha_baja');
        $stock_insumo->cantidad = $request->input('cantidad');
        $stock_insumo->marca = $request->input('marca');
        $stock_insumo->almacenamiento = $request->input('almacenamiento');
        $stock_insumo->certificado = $request->input('certificado');
        $stock_insumo->observaciones = $request->input('observaciones');
        $stock_insumo->insumo_id = $request->input('id');
        $stock_insumo->area = $request->input('area');
        $stock_insumo->save();
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

        $stock_insumo = Stockinsumo::findOrFail($request->id);
        $stock_insumo->area = $request->input('area');
        $stock_insumo->update($request->all());
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
        
        $stock_insumo = Stockinsumo::findOrFail($request->id);
        $stock_insumo->delete();

        return back();

    }
}
