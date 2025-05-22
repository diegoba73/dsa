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
use App\Dbbaja;
use App\Dbredb;
use App\Dbrpadb;
use App\Dbtramite;
use App\User;

class DbbajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $nro_registro       = $request->get('nro_registro');
        $establecimiento = $request->get('establecimiento');
        $dbbajas = Dbbaja::orderBy('dbbajas.id', 'DESC')
                    ->nro_registro($nro_registro)
                    ->establecimiento($establecimiento)
                    ->paginate(20);
        $user = User::pluck('usuario');
        return view('/db/baja/index')->with(compact('dbbajas', 'user')); // listado notas db
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $redb = null;
        $rpadb = null;
    
        if ($request->has('redb_id')) {
            $redb = Dbredb::find($request->input('redb_id'));
        } elseif ($request->has('rpadb_id')) {
            $rpadb = Dbrpadb::find($request->input('rpadb_id'));
        }
    
        if (!$redb && !$rpadb) {
            return redirect()->back()->with('error', 'No se encontró ningún Redb o Rpadb válido para procesar la baja.');
        }
    
        return view('db.baja.create')->with(compact('redb', 'rpadb'));
    }

    public function store(Request $request)
    {
        $dbbaja = new Dbbaja();
        $numero_siguiente = 1; // Valor predeterminado

        $ultimo_registro = Dbbaja::latest('id')->first();
        
        if ($ultimo_registro) {
            $numero_siguiente = $ultimo_registro->numero + 1;
        }
    
        // Asignar valores al modelo Dbbaja
        $dbbaja->numero = $numero_siguiente;
        $dbbaja->fecha_baja = $request->input('fecha_baja');
        $dbbaja->caja = $request->input('caja');
        $dbbaja->motivo = $request->input('motivo');
        $dbbaja->expediente = $request->input('expediente');
        $dbbaja->nro_registro = $request->input('nro_registro');
        $dbbaja->establecimiento = $request->input('establecimiento');
        $dbbaja->solicito = $request->input('solicito');
        $dbbaja->user_id = Auth::id();
        $dbbaja->save(); // Guardar la baja
    
        // Procesar la baja para un establecimiento
        if ($request->filled('redb_id')) {
            $redb = Dbredb::find($request->redb_id);
            if ($redb) {
                // Asignar la baja al establecimiento
                $redb->dbbaja_id = $dbbaja->id;
                $redb->fecha_baja = Carbon::now();
                $redb->save();
    
                // Actualizar el trámite relacionado
                $tramite = Dbtramite::where('dbredb_id', $redb->id)->latest()->first();
                if ($tramite) {
                    $tramite->estado = 'FINALIZADO';
                    $tramite->finalizado = 1;
                    $tramite->save();
                }
    
            } else {
                return redirect()->back()->with('error', 'Establecimiento no encontrado.');
            }
    
        // Procesar la baja para un producto
        } elseif ($request->filled('rpadb_id')) {
            $rpadb = Dbrpadb::find($request->rpadb_id);
            if ($rpadb) {
                $rpadb->dbbaja_id = $dbbaja->id;
                $rpadb->fecha_baja = Carbon::now();
                $rpadb->save();
    
                // Actualizar el trámite relacionado
                $tramite = Dbtramite::where('dbrpadb_id', $rpadb->id)->latest()->first();
                if ($tramite) {
                    $tramite->estado = 'FINALIZADO';
                    $tramite->finalizado = 1;
                    $tramite->save();
                }
    
            } else {
                return redirect()->back()->with('error', 'Producto no encontrado.');
            }
        }
    
        // Notificación de éxito
        $notification = 'La baja fue INGRESADA correctamente.';
        return redirect('/redb/index')->with(compact('notification'));
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
        $dbbaja = Dbbaja::findOrFail($id); // Recupera la baja por su ID
    
        // Busca el establecimiento o producto relacionado con la baja
        $redb = Dbredb::where('dbbaja_id', $id)->first();
        $rpadb = Dbrpadb::where('dbbaja_id', $id)->first();
    
        if (!$dbbaja) {
            return redirect()->back()->with('error', 'No se encontró la baja.');
        }
    
        return view('db.baja.edit', compact('dbbaja', 'redb', 'rpadb'));
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
        \Log::info("Update method called for ID: $id");
    
        $dbbaja = Dbbaja::find($id);
        if (!$dbbaja) {
            \Log::error("Dbbaja not found for ID: $id");
            return redirect()->route('db_baja_index')->with('error', 'No se encontró la baja.');
        }
    
        \Log::info("Dbbaja found: " . json_encode($dbbaja->toArray()));
    
        // Validar datos
        try {
            $validatedData = $request->validate([
                'fecha_baja' => 'required|date',
                'caja' => 'required|string|max:255',
                'motivo' => 'required|string',
                'expediente' => 'required|string|max:255',
                'nro_registro' => 'required|string|max:255',
                'establecimiento' => 'required|string|max:255',
                'solicito' => 'required|string|max:255',
            ]);
            \Log::info("Validation passed: " . json_encode($validatedData));
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error("Validation failed: " . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors());
        }
    
        // Actualizar los datos de la baja
        try {
            $dbbaja->update($validatedData);
            \Log::info("Dbbaja updated: " . json_encode($dbbaja->toArray()));
        } catch (\Exception $e) {
            \Log::error("Error updating Dbbaja: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la baja.');
        }
    
        // Actualizar la relación correspondiente
        try {
            if ($dbbaja->dbredb_id) { // Si la baja está asociada a un Redb
                $redb = Dbredb::find($dbbaja->dbredb_id);
                if ($redb) {
                    $redb->fecha_baja = $dbbaja->fecha_baja;
                    $redb->save();
                    \Log::info("Redb updated: " . json_encode($redb->toArray()));
                } else {
                    \Log::warning("Redb not found for dbredb_id: " . $dbbaja->dbredb_id);
                }
            } elseif ($dbbaja->dbrpadb_id) { // Si la baja está asociada a un Rpadb
                $rpadb = Dbrpadb::find($dbbaja->dbrpadb_id);
                if ($rpadb) {
                    $rpadb->fecha_baja = $dbbaja->fecha_baja;
                    $rpadb->save();
                    \Log::info("Rpadb updated: " . json_encode($rpadb->toArray()));
                } else {
                    \Log::warning("Rpadb not found for dbrpadb_id: " . $dbbaja->dbrpadb_id);
                }
            } else {
                \Log::info("No associated Redb or Rpadb found for this Dbbaja.");
            }
        } catch (\Exception $e) {
            \Log::error("Error updating related model: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la relación de la baja.');
        }
    
        \Log::info("Redirecting to db_baja_index with success message.");
    
        return redirect()->route('db_baja_index')->with('success', 'La baja se actualizó correctamente.');
    }
    

    public function expediente(Request $request)
    {
        $dbexp = new Dbexp();
        $registros_tabla = Dbexp::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Dbexp::orderBy('id', 'desc')->first();
                $ultimo_ano = Carbon::parse($ultimo_registro->fecha)->year;
                $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 
                }
        $dbexp->numero = $numero_siguiente;
        // Obtener la fecha del formulario
        $fechaFormulario = $request->input('fecha');

        // Verificar si la fecha del formulario es nula o está vacía
        if ($fechaFormulario === null || $fechaFormulario === '') {
            // Asignar la fecha actual si la fecha del formulario es nula o está vacía
            $fechaActual = now(); // Obtiene la fecha y hora actual
            $dbexp->fecha = $fechaActual;
        } else {
            // Asignar la fecha del formulario si no es nula
            $dbexp->fecha = $fechaFormulario;
        }
        $dbexp->descripcion = $request->input('descripcion');
        $dbexp->user_id = Auth::id();
        $dbexp->save(); // Insert nota
        $nroexp = Dbexp::orderBy('id', 'desc')->first();
        $year = date('y');
        $notification = 'La nota fue INGRESADA correctamente. Nº de Nota: ' . $nroexp->numero . '/' . $year;
        return back()->withInput()->with(compact('notification'));
    }

}
