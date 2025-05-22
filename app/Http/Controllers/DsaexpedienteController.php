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
use App\Dsaexpediente;
use App\Pedido;
use App\Reactivo;
use App\Insumo;
use App\Articulo;
use App\Dsanota;
use \PDF;
use Session;

class DsaexpedienteController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $nro_nota       = $request->get('nro_nota');
        $nro_expediente       = $request->get('nro_expediente');
        $descripcion       = $request->get('descripcion');
        $dsaexpedientes = Dsaexpediente::orderBy('id', 'DESC')
                    ->nro_nota($nro_nota)
                    ->nro_expediente($nro_expediente)
                    ->descripcion($descripcion)
                    ->paginate(20);
        return view('dsa.expedientes.index')->with(compact('dsaexpedientes')); // listado dsaexpedientes
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtén todos los registros de reactivos e insumos
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        
        $dsanota = Dsanota::all();
        $reactivos_pedidos = DB::table('pedido_reactivo')->whereNull('aceptado')->get();
        $insumos_pedidos = DB::table('insumo_pedido')->whereNull('aceptado')->get();
        $articulos = DB::table('articulos')->whereNull('aceptado')->get();
    
        // Obtener los IDs de los reactivos e insumos relacionados con los pedidos
        $reactivoIds = $reactivos_pedidos->pluck('reactivo_id')->toArray();
        $insumoIds = $insumos_pedidos->pluck('insumo_id')->toArray();
    
        // Obtener los reactivos e insumos relacionados con los pedidos
        $reactivos_seleccionados = Reactivo::whereIn('id', $reactivoIds)->get();
        $insumos_seleccionados = Insumo::whereIn('id', $insumoIds)->get();
    
        return view('dsa.expedientes.create')->with(compact('reactivos', 'insumos', 'dsanota', 'articulos', 'reactivos_pedidos', 'insumos_pedidos', 'reactivos_seleccionados', 'insumos_seleccionados'));
    }
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nro_nota' => 'required',
            'descripcion' => 'required',
            'reactivo' => 'array',
            'insumo' => 'array',
            'item' => 'array',
            'cantidad' => 'array',
            'aceptado_articulo' => 'array',
        ]);
    
        // Crear un nuevo expediente
        $expediente = new Dsaexpediente();
        $expediente->nro_nota = $request->input('nro_nota');
        $expediente->descripcion = $request->input('descripcion');
        $expediente->estado = 'INICIO';
        $expediente->costo_total = 0; // Se actualizará más adelante
        $expediente->users_id = $this->auth->user()->id;
        $expediente->save();
    
        $aceptados_reactivos = $request->has('aceptado_reactivo') ? $request->input('aceptado_reactivo') : [];
        $aceptados_insumos = $request->has('aceptado_insumo') ? $request->input('aceptado_insumo') : [];
        $aceptados_articulos = $request->has('aceptado_articulo') ? $request->input('aceptado_articulo') : [];
    
        $costo_total = 0;
    
        // Actualizar el campo aceptado y dsaexpediente_id en la tabla pedido_reactivo
        foreach ($aceptados_reactivos as $aceptado_reactivo) {
            $pedido_reactivo = DB::table('pedido_reactivo')
                ->where('id', $aceptado_reactivo)
                ->update([
                    'aceptado' => 1,
                    'dsaexpediente_id' => $expediente->id,
                ]);
    
            // Obtener el costo y la cantidad del reactivo seleccionado
            $reactivo = DB::table('reactivos')
                ->join('pedido_reactivo', 'reactivos.id', '=', 'pedido_reactivo.reactivo_id')
                ->where('pedido_reactivo.id', $aceptado_reactivo)
                ->select('reactivos.costo', 'pedido_reactivo.cantidad_pedida')
                ->first();
    
            // Calcular el costo total del reactivo
            $costo_total += $reactivo->costo * $reactivo->cantidad_pedida;
        }
    
        // Actualizar el campo aceptado y dsaexpediente_id en la tabla insumo_pedido
        foreach ($aceptados_insumos as $aceptado_insumo) {
            $insumo_pedido = DB::table('insumo_pedido')
                ->where('id', $aceptado_insumo)
                ->update([
                    'aceptado' => 1,
                    'dsaexpediente_id' => $expediente->id,
                ]);
    
            // Obtener el costo y la cantidad del insumo seleccionado
            $insumo = DB::table('insumos')
                ->join('insumo_pedido', 'insumos.id', '=', 'insumo_pedido.insumo_id')
                ->where('insumo_pedido.id', $aceptado_insumo)
                ->select('insumos.costo', 'insumo_pedido.cantidad_pedida')
                ->first();
    
            // Calcular el costo total del insumo
            $costo_total += $insumo->costo * $insumo->cantidad_pedida;
        }
    
        // Actualizar el campo aceptado y dsaexpediente_id en la tabla articulos
        foreach ($aceptados_articulos as $aceptado_articulo) {
            $articulo = DB::table('articulos')
                ->where('id', $aceptado_articulo)
                ->update([
                    'aceptado' => 1,
                    'dsaexpediente_id' => $expediente->id,
                ]);
    
            // Obtener el precio y la cantidad del artículo seleccionado
            $articulo = DB::table('articulos')
                ->where('id', $aceptado_articulo)
                ->select('precio', 'cantidad')
                ->first();
    
            // Calcular el costo total del artículo
            $costo_total += $articulo->precio * $articulo->cantidad;
        }
    
        // Actualizar el campo costo_total en el expediente
        $expediente->costo_total = $costo_total;
        $expediente->save();
    
        return redirect()->back()->with('success', 'Expediente creado con éxito.');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $dsaexpediente = Dsaexpediente::find($id);
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        $nro_expediente = $request->get('nro_expediente');
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('dsa.expedientes.show')->with(compact('dsaexpediente', 'reactivos', 'insumos', 'url', 'articulos'));  // mostrar dsaexpediente
    }

    public function destroy($id)
{
    $dsaexpediente = Dsaexpediente::findOrFail($id); 
    $dsaexpediente->reactivos()->detach();
    $dsaexpediente->insumos()->detach();
    $dsaexpediente->delete();

    $notification = 'El EXPEDIENTE fué ELIMINADO correctamente.';
        return redirect('/dsa/expedientes/index')->with(compact('notification'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        

    public function imprimir($id)
    {
        $dsaexpediente = Dsaexpediente::find($id);
        $reactivos = Reactivo::all();
        $insumos = Insumo::all();
        $articulos = DB::table('articulos')->where('dsaexpediente_id', $id)->get();
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

        return view('dsa.expedientes.imprimir')->with(compact('dsaexpediente', 'reactivos', 'insumos', 'articulos', 'totalr', 'totali', 'totala'));

    } 

    public function modificar (Request $request)
    {
        $id = $request->input('id');
        $dsaexpediente = Dsaexpediente::findOrFail($id);
        $dsaexpediente->nro_nota = $request->input('nro_nota');
        $dsaexpediente->nro_expediente = $request->input('nro_expediente');
        $dsaexpediente->descripcion = $request->input('descripcion');
        $dsaexpediente->fecha_expediente = $request->input('fecha_expediente');
        $dsaexpediente->estado = $request->input('estado');
        $dsaexpediente->observaciones = $request->input('observaciones');
        $dsaexpediente->costo_total = $request->input('costo_total');
        $dsaexpediente->save();
        $notification = 'Se ingresaron correctamente los datos.';
        return back()->with(compact('notification'));
    }
}