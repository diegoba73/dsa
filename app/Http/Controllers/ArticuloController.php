<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Articulo;
use App\Pedido;

class ArticuloController extends Controller
{
    public function store(Request $request)
    {
        
        $articulo = new Articulo();
        $articulo->item = $request->input('item');
        $articulo->cantidad = $request->input('cantidad');
        $articulo->cantidad_entregada = $request->input('cantidad_entregada');
        $articulo->precio = $request->input('precio');
        $articulo->save();
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

        $articulo = Articulo::findOrFail($request->id);

        $articulo->update($request->all());
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
        
        $articulo = Articulo::findOrFail($request->id);
        $articulo->delete();

        return back();

    }
}
