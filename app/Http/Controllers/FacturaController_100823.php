<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Remitente;
use App\User;
use App\Muestra;
use App\Tipomuestra;
use App\Departamento;
use App\Ensayo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numero       = $request->get('id');
        $remite      = $request->get('remitente');
        $facturas = Factura::orderBy('facturas.id', 'DESC')
                    ->numero($numero)
                    ->remite($remite)
                    ->paginate(20);
        $user = User::all();
        $departamento = Departamento::all();
        $remitentes = Remitente::all();
        return view('lab.facturas.index')->with(compact('facturas', 'remitentes', 'user', 'departamento')); // listado facturas
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        $factura = Factura::findOrFail($request->id);
        $factura->fecha_pago = $request->input('fecha_pago');
        $factura->estado = 'PAGADA';
        $factura->save();
        return redirect()->route('facturas_index')->with('success', 'Fecha de pago actualizada correctamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        Muestra::where('factura_id', $id)
            ->update(['factura_id' => null]);
        $factura->delete();
        return redirect()->route('facturas_index')->with('success', 'Factura eliminada exitosamente');
    }

    public function imprimir_factura($id)
    {
        $factura = Factura::findOrFail($id);
        $muestras = Muestra::where('factura_id', $id)->get();
        $ensayos = [];
        foreach ($muestras as $muestra) {
            foreach ($muestra->ensayos as $ensayo) {
                if (isset($ensayos[$ensayo->id])) {
                    $ensayos[$ensayo->id]['cantidad'] += 1;
                } else {
                    $ensayos[$ensayo->id] = [
                        'ensayo' => $ensayo->ensayo,
                        'cantidad' => 1,
                        'costo' => $ensayo->costo,
                    ];
                }
            }
        }  
        $remitente = Remitente::pluck('nombre');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $departamento = Departamento::pluck('departamento');
        $user = User::all();
        return view('lab.facturas.fac')->with(compact('factura', 'muestras', 'remitente', 'ensayos', 'departamento', 'tipomuestra', 'user'));
    }
    
    public function subirPago(Request $request, $id)
    {
        $factura = Factura::find($id);
    
        if ($request->isMethod('post')) {
            if ($request->hasFile('factura')) {
                $facturaArchivo = $request->file('factura');
                $nombreFactura = $request->input('nombre_factura');
                $extension = $facturaArchivo->getClientOriginalExtension();
                $nombreCompleto = $nombreFactura . '.' . $extension;
                $ruta = Storage::disk('local')->putFileAs('facturas', $facturaArchivo, $nombreCompleto);
                $factura->ruta = $ruta;
            }
    
            // Actualizar otros campos si es necesario
            $factura->nombre = $request->input('nombre_factura');
            // Otros campos si los tienes
    
            $factura->save();
    
            $notification = 'La factura fue cargada correctamente.';
            return redirect()->route('facturas_index')->with(compact('notification'));
        }
    
        // Cargar la vista del modal con los datos de la factura
        return view('lab.facturas.index')->with(compact('factura'));
    }
    
    
}
