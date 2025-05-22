<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Remitente;
use App\User;
use App\Muestra;
use App\Tipomuestra;
use App\Departamento;
use App\Ensayo;
use App\Nomenclador;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Exports\FacturasFiltroExport;
use Maatwebsite\Excel\Facades\Excel;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $numero = $request->get('numero');
        $remitente = $request->get('remitente');
        $departamento = $request->get('departamento');
        $fechaPagoInicio = $request->get('fecha_pago_inicio');
        $fechaPagoFinal = $request->get('fecha_pago_final');
        $fechaEmisionInicio = $request->get('fecha_emision_inicio');
        $fechaEmisionFinal = $request->get('fecha_emision_final');
        
        // Definir una consulta base común
        $query = Factura::orderBy('id', 'DESC')
            ->numero($numero)
            ->remitente($remitente)
            ->when($fechaPagoInicio, function ($query, $fechaPagoInicio) {
                return $query->whereDate('fecha_pago', '>=', $fechaPagoInicio);
            })
            ->when($fechaPagoFinal, function ($query, $fechaPagoFinal) {
                return $query->whereDate('fecha_pago', '<=', $fechaPagoFinal);
            })
            ->when($fechaEmisionInicio, function ($query, $fechaEmisionInicio) {
                return $query->whereDate('fecha_emision', '>=', $fechaEmisionInicio);
            })
            ->when($fechaEmisionFinal, function ($query, $fechaEmisionFinal) {
                return $query->whereDate('fecha_emision', '<=', $fechaEmisionFinal);
            });
        
        // Agregar condiciones específicas según el tipo de usuario
        if (in_array($user->id, [2, 22])) {
            $facturas = $query->paginate(20);
        } elseif (in_array($user->id, [6, 30])) {
            $facturas = $query
                ->where(function ($query) {
                    $query->where('facturas.departamentos_id', 3)
                        ->orWhere('facturas.departamentos_id', 4);
                })
                ->paginate(20);
        } else {
            $facturas = $query
                ->where('departamentos_id', $user->departamento_id)
                ->paginate(20);
        }
        
        $remitentes = Remitente::all();
        $user = User::all();
        $departamentos = Departamento::all();
        $request->session()->put('factura_filters', $request->all());

        return view('lab.facturas.index', compact('facturas', 'remitentes', 'user', 'departamentos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $userDepartamentoId = $user->departamento_id;
        $remitentes = Remitente::all();
        $nomencladors = Nomenclador::all();
        $factura = new Factura(); // Crear una nueva instancia de Factura si es necesario
        return view('lab.facturas.create', compact('nomencladors', 'factura', 'remitentes', 'userDepartamentoId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los campos del formulario
        $this->validate($request, [
            'fecha_emision' => 'required|date',
            'remitente' => 'required|string',
        ]);
    
        $factura = new Factura();
        $user = Auth::user();
        $factura->departamentos_id = $user->departamento_id;
        $factura->fecha_emision = $request->input('fecha_emision');
        $factura->fecha_pago = $request->input('fecha_pago');
        $factura->remitentes_id = $request->input('remitente');
        $factura->estado = 'NO PAGADA';
        $factura->users_id = Auth::user()->id;
        $fecha_vencimiento = now()->addDays(15);
        $factura->fecha_vencimiento = $fecha_vencimiento;    
        $factura->save();
    
        $total = 0;
    
        foreach ($request->input('selected_nomencladors', []) as $nomencladorId) {
            $cantidad = $request->input('nomenclador_cantidades.' . $nomencladorId);
    
            if ($cantidad > 0) {
                $nomenclador = Nomenclador::findOrFail($nomencladorId);
                $subtotal = $nomenclador->valor * $cantidad;
    
                $factura->nomencladors()->attach([$nomencladorId => ['cantidad' => $cantidad, 'subtotal' => $subtotal]]);
    
                $total += $subtotal;
            }
        }
    
        $factura->total = $total;
        $factura->save();
    
        return redirect()->route('facturas_index')->with('success', 'Factura ingresada correctamente.');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        $user = Auth::user();
        $userDepartamentoId = $user->departamento_id;
        $nomencladors = Nomenclador::all();
        return view('lab.facturas.edit', compact('factura', 'nomencladors', 'userDepartamentoId'));
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
    
        $factura = Factura::findOrFail($id);   
        // Actualiza los ítems del nomenclador para esta factura
        $factura->nomencladors()->detach();
    
        foreach ($request->input('selected_nomencladors', []) as $nomencladorId) {
            $cantidad = $request->input('nomenclador_cantidades.' . $nomencladorId);
    
            if ($cantidad > 0) {
                $nomenclador = Nomenclador::findOrFail($nomencladorId);
                $subtotal = $nomenclador->valor * $cantidad;
    
                // Adjunta los nomencladores seleccionados a la factura con sus cantidades y subtotales
                $factura->nomencladors()->attach([$nomencladorId => ['cantidad' => $cantidad, 'subtotal' => $subtotal]]);
            }
        }
    
        $factura->total += $factura->nomencladors->sum('pivot.subtotal');
        $factura->save();
    
        return redirect()->route('facturas_index')->with('success', 'Factura actualizada correctamente.');
    }

    public function cargaFactura(Request $request, Factura $factura)
    {
        $factura = Factura::findOrFail($request->id);
        
        // Actualizar la fecha de pago y estado
        $factura->fecha_pago = $request->input('fecha_pago');
        $factura->estado = 'PAGADA';
    
        // Subir el archivo y guardar sus detalles en la factura
        if ($request->hasFile('factura')) {
            $facturaArchivo = $request->file('factura');
            $nombreFactura = $request->input('nombre_factura');
            $identificacion = $factura->id . '_' . date('dmY') . '_' . $nombreFactura  . '.' .$facturaArchivo->getClientOriginalExtension();
            $ruta = Storage::disk('local')->putFileAs('facturas', $facturaArchivo, $identificacion);
            
            $factura->nombre = $identificacion;
            $factura->ruta = $ruta;
        }
    
        $factura->save();
    
        return redirect()->route('facturas_index')->with('success', 'Fecha de pago y archivo actualizados correctamente.');
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
        
        // Elimina los registros de la tabla pivote sin eliminar los nomencladores
        $factura->nomencladors()->detach();
        
        // Actualizar las muestras relacionadas para que no tengan factura_id
        Muestra::where('factura_id', $id)
            ->update(['factura_id' => null]);
        
        // Eliminar la factura
        $factura->delete();
        
        // Realizar cualquier otra operación relacionada aquí, como actualizar datos
        
        return redirect()->route('facturas_index')->with('success', 'Factura eliminada exitosamente.');
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
        $nomencladors = Nomenclador::all();
        $user = User::all();
        return view('lab.facturas.fac')->with(compact('factura', 'muestras', 'remitente', 'ensayos', 'departamento', 'tipomuestra', 'user', 'nomencladors'));
    }
    public function verArchivo($id)
    {
        $factura = Factura::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$factura->ruta);
    
        return Response::download($rutaArchivo, null, [], 'inline');
    }
    
    public function exportExcel(Request $request)
    {
        $filters = $request->session()->get('factura_filters', []);

        $facturasFiltroExport = new FacturasFiltroExport(
            $filters['numero'] ?? null,
            $filters['remitente'] ?? null,
            $filters['departamento'] ?? null,
            $filters['fecha_emision_inicio'] ?? null,
            $filters['fecha_emision_final'] ?? null,
            $filters['fecha_pago_inicio'] ?? null,
            $filters['fecha_pago_final'] ?? null
        );
    
        return Excel::download($facturasFiltroExport, 'factura-listado.xls');
    }
    
    
}
