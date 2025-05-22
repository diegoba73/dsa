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
use App\Microorganismo;
use App\Proveedor;
use App\Cepa;

class MicroorganismoController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 7 || Auth::user()->role_id == 8){
        $microorganismos = Microorganismo::with('cepas')
                    ->orderBy('microorganismos.id', 'DESC')
                    ->paginate(20);
        } 
        
        return view('lab.cepario.index')->with(compact('microorganismos')); // listado reactivos
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $microorganismos = Microorganismo::all();
        $proveedors = Proveedor::all();
        return view('lab.cepario.create')->with(compact('microorganismos', 'proveedors'));  // formulario reactivo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'numero.required' => 'El número es requerido',
            'microorganismo.required' => 'El microorganismo es requerido',

        ];
        
        $rules = [
            'numero' => 'required',
            'microorganismo' => 'required',
        ];

        $this->validate($request, $rules, $message);

        $microorganismo = new Microorganismo();
        $microorganismo->numero = $request->input('numero');
        $microorganismo->microorganismo = $request->input('microorganismo');
        $microorganismo->medio_cultivo = $request->input('medio_cultivo');
        $microorganismo->condiciones = $request->input('condiciones');
        $microorganismo->tsi = $request->input('tsi');
        $microorganismo->citrato = $request->input('citrato');
        $microorganismo->lia = $request->input('lia');
        $microorganismo->urea = $request->input('urea');
        $microorganismo->sim = $request->input('sim');
        $microorganismo->esculina = $request->input('esculina');
        $microorganismo->hemolisis = $request->input('hemolisis');
        $microorganismo->tumbling = $request->input('tumbling');
        $microorganismo->fluorescencia = $request->input('fluorescencia');
        $microorganismo->coagulasa = $request->input('coagulasa');
        $microorganismo->oxidasa = $request->input('oxdasa');
        $microorganismo->catalasa = $request->input('catalasa');
        $microorganismo->gram = $request->input('gram');
        $microorganismo->observaciones = $request->input('observaciones');
        $microorganismo->proveedor_id = $request->input('proveedor_id');
        $microorganismo->save(); // Insert microorganismo
        $notification = 'El microorganismo fué INGRESADO correctamente.';
        return redirect('/lab/cepario/index')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cepa($id)
    {
        $microorganismo = Microorganismo::find($id); 
        $cepas = Cepa::where('microorganismo_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        $proveedor = Proveedor::where('id', $microorganismo->proveedor_id);
        $user = User::pluck('usuario');
        Session::put('url', $url);
        return view('lab.cepario.cepa')->with(compact('microorganismo', 'cepas', 'proveedor', 'user', 'url')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $microorganismo = Microorganismo::find($id); 
        $proveedors = Proveedor::all();
        $url = redirect()->getUrlGenerator()->previous();
        return view('lab.cepario.edit')->with(compact('microorganismo', 'proveedors', 'url'));  // editar reactivo    
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
        $microorganismo = Microorganismo::find($id); 
        $microorganismo->numero = $request->input('numero');
        $microorganismo->microorganismo = $request->input('microorganismo');
        $microorganismo->medio_cultivo = $request->input('medio_cultivo');
        $microorganismo->condiciones = $request->input('condiciones');
        $microorganismo->tsi = $request->input('tsi');
        $microorganismo->citrato = $request->input('citrato');
        $microorganismo->lia = $request->input('lia');
        $microorganismo->urea = $request->input('urea');
        $microorganismo->sim = $request->input('sim');
        $microorganismo->esculina = $request->input('esculina');
        $microorganismo->hemolisis = $request->input('hemolisis');
        $microorganismo->tumbling = $request->input('tumbling');
        $microorganismo->fluorescencia = $request->input('fluorescencia');
        $microorganismo->coagulasa = $request->input('coagulasa');
        $microorganismo->oxidasa = $request->input('oxdasa');
        $microorganismo->catalasa = $request->input('catalasa');
        $microorganismo->gram = $request->input('gram');
        $microorganismo->observaciones = $request->input('observaciones');
        $microorganismo->proveedor_id = $request->input('proveedor_id');
        $microorganismo->save(); // Actualizar microorganismo
        $url = Input::get('url');
        $notification = 'El microorganismo fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function imprimir_cepa(Request $request)
    {
        $microorganismos = Microorganismo::with('cepas')
                    ->orderBy('microorganismos.id', 'DESC')->get();
        $cepas = Cepa::all();           
        $pdf = PDF::loadView('lab.cepario.imprimir_cepa', compact('microorganismos', 'cepas'));
        return $pdf->stream();
    } 
}
