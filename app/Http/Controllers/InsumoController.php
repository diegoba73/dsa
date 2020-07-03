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
use Session;
use App\User;
use App\Insumo;
use App\Stockinsumo;
use App\Proveedor;
 
class InsumoController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $codigo       = $request->get('codigo');
        $nombre = $request->get('nombre');
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8){
            $insumos = Insumo::with('stockinsumos')
                    ->orderBy('insumos.id', 'DESC')
                    ->withCount(['stockinsumos as stock' => function ($query) {
                        $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
            } elseif (Auth::user()->role_id == 6) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->where('insumos.cromatografia', '=', '1')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
            } elseif (Auth::user()->role_id == 5) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->where('insumos.ensayo_biologico', '=', '1')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
            } elseif (Auth::user()->role_id == 7) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->where('insumos.microbiologia', '=', '1')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
    
            } elseif (Auth::user()->role_id == 3) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->where('insumos.quimica_al', '=', '1')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
            } elseif (Auth::user()->role_id == 4) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->select(DB::raw("SUM(cantidad)"))->where('fecha_baja', null);}])
                        ->where('insumos.quimica_ag', '=', '1')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->paginate(20);
            }

        return view('lab.insumos.index')->with(compact('insumos')); // listado insumos
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insumos = Insumo::all();

        return view('lab.insumos.create')->with(compact('insumos'));  // formulario insumo
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
            'codigo.required' => 'El código es requerido',
            'nombre.required' => 'El tipo de nombre es requerido',

        ];
        
        $rules = [
            'codigo' => 'required',
            'nombre' => 'required',
        ];

        $this->validate($request, $rules, $message);

        $insumo = new Insumo();
        $insumo->codigo = $request->input('codigo');
        $insumo->nombre = $request->input('nombre');
        $insumo->descripcion = $request->input('descripcion');
        $insumo->cromatografia = $request->input('cromatografia');
        $insumo->ensayo_biologico = $request->input('ensayo_biologico');
        $insumo->microbiologia = $request->input('microbiologia');
        $insumo->quimica_al = $request->input('quimica_al');
        $insumo->quimica_ag = $request->input('quimica_ag');
        $insumo->costo = $request->input('costo');
        $insumo->proveedor_cotizo = $request->input('proveedor_cotizo');
        $insumo->fecha_cotizacion = $request->input('fecha_cotizacion');
        $insumo->save(); // Insert nota
        $notification = 'El insumo fué INGRESADO correctamente.';
        return redirect('/lab/insumos/index')->with(compact('notification'));
    }

    public function stock($id)
    {
        $insumo = Insumo::find($id); 
        $proveedors = Proveedor::all();
        $stock_insumos = Stockinsumo::where('insumo_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('lab.insumos.stock')->with(compact('insumo', 'proveedors', 'stock_insumos', 'url')); 
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
        $insumo = Insumo::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('lab.insumos.edit')->with(compact('insumo', 'url'));  // editar insumo    
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
        $insumo = Insumo::find($id);
        $insumo->codigo = $request->input('codigo');
        $insumo->nombre = $request->input('nombre');
        $insumo->descripcion = $request->input('descripcion');
        $insumo->cromatografia = $request->input('cromatografia');
        $insumo->ensayo_biologico = $request->input('ensayo_biologico');
        $insumo->microbiologia = $request->input('microbiologia');
        $insumo->quimica_al = $request->input('quimica_al');
        $insumo->quimica_ag = $request->input('quimica_ag');
        $insumo->costo = $request->input('costo');
        $insumo->proveedor_cotizo = $request->input('proveedor_cotizo');
        $insumo->fecha_cotizacion = $request->input('fecha_cotizacion');
        $insumo->save();
        $url = Input::get('url');
        $notification = 'El insumo fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imprimir_stock(Request $request)
    {
        $codigo = $request->get('codigo');
        $nombre = $request->get('nombre');
        $cromatografia = $request->get('cromatografia');
        $quimical = $request->get('quimica_al');
        $quimicag = $request->get('quimica_ag');
        $ensayo_biologico = $request->get('ensayo_biologico');
        $microbiologia = $request->get('microbiologia');
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8){
            $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null);}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->whereIn('stockinsumos.area', ['CROMATOGRAFIA', 'ENSAYO BIOLOGICO', 'MICROBIOLOGIA', 'QUIMICA ALIMENTOS', 'QUIMICA AGUAS'])
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->cromatografia($cromatografia)
                        ->quimical($quimical)
                        ->quimicag($quimicag)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->get();
            } elseif (Auth::user()->role_id == 6) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'CROMATOGRAFIA');}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->where('stockinsumos.area', '=', 'CROMATOGRAFIA')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
            } elseif (Auth::user()->role_id == 5) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'ENSAYO BIOLOGICO');}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->where('stockinsumos.area', '=', 'ENSAYO BIOLOGICO')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
            } elseif (Auth::user()->role_id == 7) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'MICROBIOLOGIA');}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->where('stockinsumos.area', '=', 'MICROBIOLOGIA')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
    
            } elseif (Auth::user()->role_id == 3) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'QUIMICA ALIMENTOS');}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->where('stockinsumos.area', '=', 'QUIMICA ALIMENTOS')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
    
            } elseif (Auth::user()->role_id == 4) {
                $insumos = Insumo::with('stockinsumos')
                        ->orderBy('insumos.id', 'DESC')
                        ->groupBy('insumos.id')
                        ->withCount(['stockinsumos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'QUIMICA AGUAS');}])
                        ->leftjoin('stockinsumos', 'insumos.id', '=', 'stockinsumos.insumo_id')
                        ->where('stockinsumos.area', '=', 'QUIMICA AGUAS')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
    
            }  
        return view('lab.insumos.imprimir_stock')->with(compact('insumos'));
    } 
}
