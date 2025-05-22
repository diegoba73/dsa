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
use App\Reactivo;
use App\Proveedor;
use App\Stockreactivo;
use App\Pedido;
 
class ReactivoController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $pedidos = Pedido::where('finalizado', '=', '1')->get();
        $codigo = $request->get('codigo');
        $nombre = $request->get('nombre');
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 8){
        $reactivos = Reactivo::with('stockreactivos')
                    ->orderBy('reactivos.id', 'DESC')
                    ->withCount(['stockreactivos as stock' => function ($query) {
                        $query->where('fecha_baja', null);}])
                    ->codigo($codigo)
                    ->nombre($nombre)
                    ->paginate(20);
        } elseif (Auth::user()->role_id == 6) {
            $reactivos = Reactivo::with('stockreactivos')
                    ->orderBy('reactivos.id', 'DESC')
                    ->where('reactivos.cromatografia', '=', '1')
                    ->withCount(['stockreactivos as stock' => function ($query) {
                        $query->where('fecha_baja', null)->where('area', '=', 'CROMATOGRAFIA');}])
                    ->codigo($codigo)
                    ->nombre($nombre)
                    ->paginate(20);
        } elseif (Auth::user()->role_id == 5) {
            $reactivos = Reactivo::with('stockreactivos')
                    ->orderBy('reactivos.id', 'DESC')
                    ->where('reactivos.ensayo_biologico', '=', '1')
                    ->withCount(['stockreactivos as stock' => function ($query) {
                        $query->where('fecha_baja', null)->where('area', '=', 'ENSAYO BIOLOGICO');}])
                    ->codigo($codigo)
                    ->nombre($nombre)
                    ->paginate(20);
        } elseif (Auth::user()->role_id == 7) {
            $reactivos = Reactivo::with('stockreactivos')
                    ->orderBy('reactivos.id', 'DESC')
                    ->where('reactivos.microbiologia', '=', '1')
                    ->withCount(['stockreactivos as stock' => function ($query) {
                        $query->where('fecha_baja', null)->where('area', '=', 'MICROBIOLOGIA');}])
                    ->codigo($codigo)
                    ->nombre($nombre)
                    ->paginate(20);

        } elseif (Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
            $reactivos = Reactivo::with('stockreactivos')
                    ->orderBy('reactivos.id', 'DESC')
                    ->where('reactivos.quimica', '=', '1')
                    ->withCount(['stockreactivos as stock' => function ($query) {
                        $query->where('fecha_baja', null)->where('area', '=', 'QUIMICA');}])
                    ->codigo($codigo)
                    ->nombre($nombre)
                    ->paginate(20);

        }
        
        return view('lab.reactivos.index')->with(compact('reactivos', 'pedidos')); // listado reactivos
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reactivos = Reactivo::all();

        return view('lab.reactivos.create')->with(compact('reactivos'));  // formulario reactivo
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

        $reactivo = new Reactivo();
        $reactivo->codigo = $request->input('codigo');
        $reactivo->nombre = $request->input('nombre');
        $reactivo->descripcion = $request->input('descripcion');
        $reactivo->numero_cas = $request->input('numero_cas');
        $reactivo->ensayo = $request->input('ensayo');
        $reactivo->microbiologia = $request->input('microbiologia');
        $reactivo->quimica = $request->input('quimica');
        $reactivo->ensayo_biologico = $request->input('ensayo_biologico');
        $reactivo->cromatografia = $request->input('cromatografia');
        $reactivo->renpre = $request->input('renpre');
        $reactivo->costo = $request->input('costo');
        $reactivo->proveedor_cotizo = $request->input('proveedor_cotizo');
        $reactivo->fecha_cotizacion = $request->input('fecha_cotizacion');
        $reactivo->save(); // Insert nota
        $notification = 'El reactivo fué INGRESADO correctamente.';
        return redirect('/lab/reactivos/index')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stock($id)
    {
        $reactivo = Reactivo::find($id); 
        $proveedors = Proveedor::all();
    if (Auth::user()->role_id == 1 || Auth::user()->role_id == 8) {
        $stock_reactivos = Stockreactivo::where('reactivo_id', $id)
        ->get();
    } elseif (Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
        $stock_reactivos = Stockreactivo::where('reactivo_id', $id)
        ->where('area', '=', 'QUIMICA')
        ->get();
    } elseif ((Auth::user()->role_id == 5) || (Auth::user()->role_id == 6)) {
        $stock_reactivos = Stockreactivo::where('reactivo_id', $id)
        ->where('area', '=', 'ENSAYO BIOLOGICO')
        ->get();
    } elseif (Auth::user()->role_id == 6) {
        $stock_reactivos = Stockreactivo::where('reactivo_id', $id)
        ->where('area', '=', 'CROMATOGRAFIA')
        ->get();
    } elseif (Auth::user()->role_id == 7) {
        $stock_reactivos = Stockreactivo::where('reactivo_id', $id)
        ->where('area', '=', 'MICROBIOLOGIA')
        ->get();
    }
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('lab.reactivos.stock')->with(compact('reactivo', 'proveedors', 'stock_reactivos', 'url')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reactivo = Reactivo::find($id);
        $url = redirect()->getUrlGenerator()->previous();
        return view('lab.reactivos.edit')->with(compact('reactivo', 'url'));  // editar reactivo    
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
        $reactivo = Reactivo::find($id);
        $reactivo->codigo = $request->input('codigo');
        $reactivo->nombre = $request->input('nombre');
        $reactivo->descripcion = $request->input('descripcion');
        $reactivo->numero_cas = $request->input('numero_cas');
        $reactivo->ensayo = $request->input('ensayo');
        $reactivo->cromatografia = $request->input('cromatografia');
        $reactivo->quimica = $request->input('quimica');
        $reactivo->ensayo_biologico = $request->input('ensayo_biologico');
        $reactivo->microbiologia = $request->input('microbiologia');
        $reactivo->renpre = $request->input('renpre');
        $reactivo->costo = $request->input('costo');
        $reactivo->proveedor_cotizo = $request->input('proveedor_cotizo');
        $reactivo->fecha_cotizacion = $request->input('fecha_cotizacion');
        $reactivo->save();
        $url = Input::get('url');
        $notification = 'El reactivo fué ACTUALIZADO correctamente.';
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
        $quimica = $request->get('quimica');
        $ensayo_biologico = $request->get('ensayo_biologico');
        $microbiologia = $request->get('microbiologia');
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8){
            $reactivos = Reactivo::with('stockreactivos')
                        ->orderBy('reactivos.id', 'DESC')
                        ->groupBy('reactivos.id')
                        ->withCount(['stockreactivos as stock' => function ($query) {
                            $query->where('fecha_baja', null);}])
                        ->leftjoin('stockreactivos', 'reactivos.id', '=', 'stockreactivos.reactivo_id')
                        ->whereIn('stockreactivos.area', ['CROMATOGRAFIA', 'ENSAYO BIOLOGICO', 'MICROBIOLOGIA', 'QUIMICA'])
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->cromatografia($cromatografia)
                        ->quimica($quimica)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->get();
            } elseif (Auth::user()->role_id == 6) {
                $reactivos = Reactivo::with('stockreactivos')
                        ->orderBy('reactivos.id', 'DESC')
                        ->groupBy('reactivos.id')
                        ->withCount(['stockreactivos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'CROMATOGRAFIA');}])
                        ->leftjoin('stockreactivos', 'reactivos.id', '=', 'stockreactivos.reactivo_id')
                        ->where('stockreactivos.area', '=', 'CROMATOGRAFIA')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
            } elseif (Auth::user()->role_id == 5) {
                $reactivos = Reactivo::with('stockreactivos')
                        ->orderBy('reactivos.id', 'DESC')
                        ->groupBy('reactivos.id')
                        ->withCount(['stockreactivos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'ENSAYO BIOLOGICO');}])
                        ->leftjoin('stockreactivos', 'reactivos.id', '=', 'stockreactivos.reactivo_id')
                        ->where('stockreactivos.area', '=', 'ENSAYO BIOLOGICO')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
            } elseif (Auth::user()->role_id == 7) {
                $reactivos = Reactivo::with('stockreactivos')
                        ->orderBy('reactivos.id', 'DESC')
                        ->groupBy('reactivos.id')
                        ->withCount(['stockreactivos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'MICROBIOLOGIA');}])
                        ->leftjoin('stockreactivos', 'reactivos.id', '=', 'stockreactivos.reactivo_id')
                        ->where('stockreactivos.area', '=', 'MICROBIOLOGIA')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
    
            } elseif (Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
                $reactivos = Reactivo::with('stockreactivos')
                        ->orderBy('reactivos.id', 'DESC')
                        ->groupBy('reactivos.id')
                        ->withCount(['stockreactivos as stock' => function ($query) {
                            $query->where('fecha_baja', null)->where('area', '=', 'QUIMICA');}])
                        ->leftjoin('stockreactivos', 'reactivos.id', '=', 'stockreactivos.reactivo_id')
                        ->where('stockreactivos.area', '=', 'QUIMICA')
                        ->codigo($codigo)
                        ->nombre($nombre)
                        ->get();
    
            }       
        return view('lab.reactivos.imprimir_stock')->with(compact('reactivos'));
    } 
}
