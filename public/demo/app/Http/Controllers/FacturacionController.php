<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarFormularioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Facturacion;
use App\User;
use App\Exports\FacturasExport;


class FacturacionController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $fecha_e       = $request->get('fechae');
        $fecha_p       = $request->get('fechap');
        $detalle = $request->get('detalle');
        $departamento = $request->get('departamento');
        $depositante = $request->get('depositante');
        $facturas = Facturacion::orderBy('facturacions.id', 'DESC')
                    ->depositante($depositante)
                    ->fechae($fecha_e)
                    ->fechap($fecha_p)
                    ->detalle($detalle)
                    ->departamento($departamento)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('dsa.facturas.index')->with(compact('facturas')); // listado facturas
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facturas = Facturacion::all();

        return view('dsa.facturas.create')->with(compact('facturas'));  // formulario factura
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
            'detalle.unique' => 'María Ines NO DUPLIQUES LAS FACTURAS',
        ];

        $rules = [
            'detalle' => 'unique:facturacions,detalle',
        ];

        $this->validate($request, $rules, $message);

        $factura = new Facturacion();
        $factura->depositante = $request->input('depositante');
        $factura->fecha_emision = $request->input('fecha_emision');
        $factura->fecha_pago = $request->input('fecha_pago');
        $factura->detalle = $request->input('detalle');
        $factura->importe = $request->input('importe');
        $factura->departamento = $request->input('departamento');
        $factura->codigo_barra = $request->input('codigo_barra');
        $factura->user_id = $this->auth->user()->id;
        $factura->save(); // Insert nota
        $notification = 'La Factura fué INGRESADA correctamente.';
        return redirect('/dsa/facturas/index')->with(compact('notification'));
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
        $factura = Facturacion::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('dsa.facturas.edit')->with(compact('factura', 'url'));  // editar factura    
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
        $factura = Facturacion::find($id);
        $factura->depositante = $request->input('depositante');
        $factura->fecha_emision = $request->input('fecha_emision');
        $factura->fecha_pago = $request->input('fecha_pago');
        $factura->detalle = $request->input('detalle');
        $factura->importe = $request->input('importe');
        $factura->departamento = $request->input('departamento');
        $factura->codigo_barra = $request->input('codigo_barra');
        $factura->user_id = $this->auth->user()->id;
        $factura->save();
        $url = Input::get('url');
        $notification = 'La Factura fué ACTUALIZADA correctamente.';
        return redirect($url)->with(compact('notification'));
    }

    public function exportExcel()
    {
        return Excel::download(new FacturasExport, 'factura-listado.xls');
    }

    public function destroy(Request $request)
    {
        
        $facturacion = Facturacion::findOrFail($request->id);
        $facturacion->delete();
        $notification = 'La Factura del Depositante: "'. $facturacion->depositante .'" fué ELIMINADA correctamente.';
        return redirect('/dsa/facturas/index')->with(compact('notification'));

        return back();

    }
}
