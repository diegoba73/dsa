<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Analito;
use App\Muestra;

class AnalitoController extends Controller
{
    public function store(Request $request)
    {
        
        $analito = new Analito();
        $analito->analito = $request->input('analito');
        $analito->valor_hallado = $request->input('valor_hallado');
        $analito->unidad = $request->input('unidad');
        $analito->parametro_calidad = $request->input('parametro_calidad');
        $analito->muestra_id = $request->input('id');
        $analito->save();
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

        $analito = Analito::findOrFail($request->id);

        $analito->update($request->all());
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
        
        $analito = Analito::findOrFail($request->id);
        $analito->delete();

        return back();

    }
}
