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
use App\User;
use App\Pedido;
use App\Reactivo;
use App\Insumo;
use App\Articulo;
use App\Departamento;
use App\Dlnota;
use \PDF;
use Session;

class PedidoController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $nro_pedido       = $request->get('nro_pedido');
        $nro_nota       = $request->get('nro_nota');
        $nro_expediente       = $request->get('nro_expediente');
        $descripcion       = $request->get('descripcion');
        $dpto       = $request->get('dpto');
        $user = Auth::user()->id;
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 12 || Auth::user()->role_id == 8)&&(Auth::user()->departamento_id == 1 || Auth::user()->departamento_id == 5)){
        $pedidos = Pedido::orderBy('id', 'DESC')
                    ->nro_pedido($nro_pedido)
                    ->nro_nota($nro_nota)
                    ->nro_expediente($nro_expediente)
                    ->descripcion($descripcion)
                    ->dpto($dpto)
                    ->paginate(20);
        } else  {
            $pedidos = Pedido::orderBy('id', 'DESC')
                    ->where('pedidos.user_id', '=', auth()->user()->id)
                    ->nro_pedido($nro_pedido)
                    ->nro_nota($nro_nota)
                    ->nro_expediente($nro_expediente)
                    ->descripcion($descripcion)
                    ->dpto($dpto)
                    ->paginate(20);
        }
        $dptos = Departamento::all();
        return view('dsa.pedidos.index')->with(compact('pedidos', 'dptos')); // listado pedidos
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8 || Auth::user()->role_id == 12){
            $reactivos = Reactivo::all(); 
        } elseif (Auth::user()->role_id == 6) {
            $reactivos = Reactivo::where('reactivos.cromatografia', '=', '1')->get();
        } elseif (Auth::user()->role_id == 5) {
            $reactivos = Reactivo::where('reactivos.ensayo_biologico', '=', '1')->get();
        } elseif (Auth::user()->role_id == 7) {
            $reactivos = Reactivo::where('reactivos.microbiologia', '=', '1')->get();
        } elseif (Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
            $reactivos = Reactivo::where('reactivos.quimica', '=', '1')->get();
        }
        $insumos = Insumo::all();
        $dlnota = Dlnota::all();
        return view('dsa.pedidos.create')->with(compact('reactivos', 'insumos', 'dlnota'));  // formulario pedido
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
            'descripcion.required' => 'La descripción es requerida',

        ];
        
        $rules = [
            'descripcion' => 'required',
        ];

        $this->validate($request, $rules, $message);


        $reactivo = Input::get('reactivo');
        $insumo = Input::get('insumo');
        $item = Input::get('item');
        $cantidad = Input::get('cantidad');
        $precio = Input::get('precio');
        if (((!empty($reactivo)) && (!empty($insumo))) || ((!empty($reactivo)) && (!empty($item))) || ((!empty($insumo)) && (!empty($item)))) {
        $notification = 'Haga bien su pedido... recuerde que se pide por separado Insumos, Reactivos o Artículos.';
        return back()->with(compact('notification'));        
        } else { 
        $pedido = new Pedido();
        $registros_tabla = Pedido::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Pedido::orderBy('id', 'desc')->first();
                $numero_siguiente = $ultimo_registro->nro_pedido+1;
                }
        $pedido->nro_pedido = $numero_siguiente;
        $pedido->fecha_pedido = now();
        $pedido->descripcion = $request->input('descripcion');
        $pedido->estado = $request->input('estado', 'INICIO');
        $pedido->fecha_expediente = $request->input('fecha_expediente');
        $pedido->nro_nota = $request->input('nro_nota');
        $pedido->nro_expediente = $request->input('nro_expediente');
        $pedido->user_id = $this->auth->user()->id;
        $pedido->departamento_id = $this->auth->user()->departamento_id;
        $pedido->save(); // Insert pedido

        if (!empty($reactivo)) {
        $syncData = [];
            for($i = 0; $i < count($reactivo); $i++)
                $syncData[$reactivo[$i]] = ['cantidad_pedida' => $cantidad[$i]];
        $pedido->reactivos()->sync($syncData);
        $notification = 'El pedido fué INGRESADO correctamente.';
        return redirect('/dsa/pedidos/index')->with(compact('notification'));
        } elseif (!empty($insumo)) {
            $syncData = [];
            for($i = 0; $i < count($insumo); $i++)
                $syncData[$insumo[$i]] = ['cantidad_pedida' => $cantidad[$i]];
        $pedido->insumos()->sync($syncData);
        $notification = 'El pedido fué INGRESADO correctamente.';
        return redirect('/dsa/pedidos/index')->with(compact('notification'));
        } else {
            $pedido_id = Pedido::orderBy('id', 'desc')->first();
            for ($i = 0; $i < count($item); $i++) {
                $articulo = new Articulo();
                $articulo->item =  $item[$i];
                $articulo->cantidad=  $cantidad[$i];
                $articulo->precio =  $precio[$i];
                $articulo->pedido_id = $pedido_id->id;
                $articulo->save(); 
            }

        $notification = 'El pedido fué INGRESADO correctamente.';
        return redirect('/dsa/pedidos/index')->with(compact('notification'));
        }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $pedido = Pedido::with('articulos')->find($id);
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        $nro_expediente = $request->get('nro_expediente');
        $articulos = DB::table('articulos')->where('pedido_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('dsa.pedidos.show')->with(compact('pedido', 'reactivos', 'insumos', 'url', 'articulos'));  // mostrar pedido
    }

    public function destroy($id)
{
    $pedido = Pedido::findOrFail($id); 
    $pedido->reactivos()->detach();
    $pedido->insumos()->detach();
    $pedido->delete();

    $notification = 'El pedido fué ELIMINADO correctamente.';
        return redirect('/dsa/pedidos/index')->with(compact('notification'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 12 || Auth::user()->role_id == 8)&&(Auth::user()->departamento_id == 1 || Auth::user()->departamento_id == 5)){
        $pedido = Pedido::findOrFail($id);
        } else {
        $pedido = Pedido::where('pedidos.departamento_id', '=', auth()->user()->departamento_id)->findOrFail($id);  
        }
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        $articulos = DB::table('articulos')->where('pedido_id', $id)->get();
        $reactivos_pedidos = DB::table('pedido_reactivo')->where('pedido_id', $id)->get();
        $insumos_pedidos = DB::table('insumo_pedido')->where('pedido_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('dsa.pedidos.edit')->with(compact('pedido', 'reactivos', 'insumos', 'url', 'reactivos_pedidos', 'insumos_pedidos', 'articulos'));  // editar pedido    
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
        $reactivo = $request->input('reactivo');
        $insumo = $request->input('insumo');
        $item = $request->input('item');
        $cantidad_entregada = $request->input('cantidad_entregada');
        $cantidad_pedida = $request->input('cantidad_pedida');
        $cantidad = $request->input('cantidad');
        $pedido = Pedido::find($id);
        $pedido->fecha_pedido = $request->input('fecha_pedido');
        $pedido->descripcion = $request->input('descripcion');
        $pedido->estado = $request->input('estado');
        $pedido->fecha_expediente = $request->input('fecha_expediente');
        $pedido->nro_nota = $request->input('nro_nota');
        $pedido->nro_expediente = $request->input('nro_expediente');
        $pedido->entrega_parcial = $request->input('entrega_parcial');
        $pedido->baja = $request->input('baja');
        $pedido->finalizado = $request->input('finalizado');
        $pedido->observaciones = $request->input('observaciones');
        $pedido->save();
        $url = Input::get('url');
        if (!empty($reactivo)) {
            $syncData = [];
            for ($i = 0; $i < count($reactivo); $i++) {
                // Agregamos comprobaciones para los valores de la matriz
                $cantidad_pedida_val = isset($cantidad_pedida[$i]) ? $cantidad_pedida[$i] : '';
                $cantidad_entregada_val = isset($cantidad_entregada[$i]) ? $cantidad_entregada[$i] : '';
                $syncData[$reactivo[$i]] = [
                    'cantidad_pedida' => $cantidad_pedida_val,
                    'cantidad_entregada' => $cantidad_entregada_val
                ];
            }
            $pedido->reactivos()->sync($syncData);
            $notification = 'El pedido de reactivos fue actualizado correctamente.';
            return redirect('/dsa/pedidos/index')->with(compact('notification'));
        } elseif (!empty($insumo)) {
            $syncData = [];
            for ($i = 0; $i < count($insumo); $i++) {
                // Agregamos comprobaciones para los valores de la matriz
                $cantidad_pedida_val = isset($cantidad_pedida[$i]) ? $cantidad_pedida[$i] : '';
                $cantidad_entregada_val = isset($cantidad_entregada[$i]) ? $cantidad_entregada[$i] : '';
                $syncData[$insumo[$i]] = [
                    'cantidad_pedida' => $cantidad_pedida_val,
                    'cantidad_entregada' => $cantidad_entregada_val
                ];
            }
            $pedido->insumos()->sync($syncData);
            $notification = 'El pedido de insumos fue actualizado correctamente.';
            return redirect('/dsa/pedidos/index')->with(compact('notification'));
        } elseif (!empty($item)) {
            for ($i = 0; $i < count($item); $i++) {
                $articulo = Articulo::where('pedido_id', $pedido->id)->where('id', $item[$i])->first();
                if (!empty($articulo)) {
                    // Agregamos una comprobación para el valor de la matriz
                    $cantidad_entregada_val = isset($cantidad_entregada[$i]) ? $cantidad_entregada[$i] : '';
                    $articulo->cantidad_entregada = $cantidad_entregada_val;
        
                    // Agregamos una comprobación para la cantidad del artículo
                    $cantidad_val = isset($cantidad[$i]) ? $cantidad[$i] : '';
                    $articulo->cantidad = $cantidad_val;
        
                    $articulo->save();
                }
            }
        
            $notification = 'El pedido de artículos fue actualizado correctamente.';
            return redirect('/dsa/pedidos/index')->with(compact('notification'));
        } else {
            $notification = 'No se realizó ninguna actualización en el pedido.';
            return redirect('/dsa/pedidos/index')->with(compact('notification'));
        }        
    }
        

    public function imprimir($id)
    {
        $pedido = Pedido::find($id);
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        $articulos = DB::table('articulos')->where('pedido_id', $id)->get();
        $totalr = DB::table('pedido_reactivo')
        ->leftJoin('reactivos', 'reactivos.id', '=', 'pedido_reactivo.reactivo_id')
        ->where('pedido_reactivo.pedido_id', $id)
        ->sum(DB::raw('pedido_reactivo.cantidad_pedida * reactivos.costo'));

        $totali = DB::table('insumo_pedido')
        ->leftJoin('insumos', 'insumos.id', '=', 'insumo_pedido.insumo_id')
        ->where('insumo_pedido.pedido_id', $id)
        ->sum(DB::raw('insumo_pedido.cantidad_pedida * insumos.costo'));

        $totala = DB::table('articulos')
        ->where('articulos.pedido_id', $id)
        ->sum(DB::raw('articulos.cantidad * articulos.precio'));

        return view('dsa.pedidos.imprimir')->with(compact('pedido', 'reactivos', 'insumos', 'articulos', 'totalr', 'totali', 'totala'));

    } 
}