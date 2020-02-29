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
use \PDF;
use Session;
use App\User;
use App\Cepa;
use App\Microorganismo;

class CepaController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        
        $cepa = new Cepa();
        
        $cepa->microorganismo_id = $request->input('id');
        $cepa->lote = $request->input('lote');
        $cepa->fecha_incubacion = $request->input('incubacion');
        $cepa->tsi = $request->input('tsi');
        $cepa->citrato = $request->input('citrato');
        $cepa->lia = $request->input('lia');
        $cepa->urea = $request->input('urea');
        $cepa->sim = $request->input('sim');
        $cepa->esculina = $request->input('esculina');
        $cepa->hemolisis = $request->input('hemolisis');
        $cepa->tumbling = $request->input('tumbling');
        $cepa->fluorescencia = $request->input('fluorescencia');
        $cepa->coagulasa = $request->input('coagulasa');
        $cepa->oxidasa = $request->input('oxdasa');
        $cepa->catalasa = $request->input('catalasa');
        $cepa->gram = $request->input('gram');
        $cepa->observaciones = $request->input('observaciones');
        $cepa->user_id = $this->auth->user()->id;
        $cepa->save();
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

        $cepa = Cepa::findOrFail($request->id);

        $cepa->update($request->all());
        $cepa->user_id = $this->auth->user()->id;
        $cepa->save();
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
        
        $cepa = Cepa::findOrFail($request->id);
        $cepa->delete();

        return back();

    }
}
