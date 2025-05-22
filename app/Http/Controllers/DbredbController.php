<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\User;
use App\Dbredb;
use App\Dbempresa;
use App\Dbrubro;
use App\Dbbaja;
use App\Dbcategoria;
use App\DbredbDbrubro;
use App\Dbhistorial;
use App\Localidad;
use App\Dbexp;
use App\Dbtramite;
use App\Dbdt;
use App\Remitente;
use App\Factura;
use App\Nomenclador;
use \PDF;
use Session;

class DbredbController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $idEmpresa = null;

        if ($user->role_id == 15) {
            $empresa = $user->empresa()->first();

            if ($empresa) {
                $idEmpresa = $empresa->id;

                $redbs = Dbredb::with('dbtramites')
                    ->byEmpresa($idEmpresa)
                    ->whereNotNull('expediente')
                    ->orderByRaw("(transito = 'PROVINCIAL') DESC, numero DESC")
                    ->paginate(20);
            } else {
                session()->flash('error', 'No tienes empresas asociadas.');
                $redbs = collect([]);
            }
        } else {
            $numero = $request->get('numero');
            $establecimiento = $request->get('establecimiento');
            $estado = $request->get('estado');

            $query = Dbredb::with('dbtramites')
                ->whereNotNull('expediente')
                ->orderByRaw("(transito = 'PROVINCIAL') DESC, numero DESC");

            // 🔒 Filtro por zona según rol del usuario (solo áreas)
            if (in_array($user->role_id, [16, 17, 18])) {
                $zona = null;
                if ($user->role_id == 16) {
                    $zona = 'APE';
                } elseif ($user->role_id == 17) {
                    $zona = 'APCR';
                } elseif ($user->role_id == 18) {
                    $zona = 'APPM';
                }

                if ($zona) {
                    $query->whereHas('localidad', function ($q) use ($zona) {
                        $q->where('zona', $zona);
                    });
                }
            }

            // 📌 Filtros opcionales
            if ($numero) {
                $query->where('numero', 'LIKE', '%' . $numero . '%');
            }

            if ($establecimiento) {
                $query->where('establecimiento', 'LIKE', '%' . $establecimiento . '%');
            }

            if ($estado) {
                $query->where(function ($query) use ($estado) {
                    if ($estado === 'ACTIVO') {
                        $query->where('fecha_reinscripcion', '>=', now())
                            ->where('dbbaja_id', 0);
                    } elseif ($estado === 'NO VIGENTE') {
                        $query->where('dbbaja_id', '=', 0)
                            ->where('fecha_reinscripcion', '<', now()->addMonth());
                    } elseif ($estado === 'PEDIDO DE MODIFICACION') {
                        $query->whereHas('dbtramites', function ($subQuery) {
                            $subQuery->where('estado', 'INICIADO')
                                ->where('tipo_tramite', 'like', '%MODIFICACION%');
                        });
                    } elseif ($estado === 'BAJA') {
                        $query->where('dbbaja_id', '!=', 0);
                    }
                });
            }

            $redbs = $query->paginate(20);
        }

        $montoInscripcion = Nomenclador::where('descripcion', 'Registro Provincial de Establecimiento')->value('valor');
        $montoModificacion = Nomenclador::where('descripcion', 'Modificación REDB')->value('valor');
        $montoReinscripcion = Nomenclador::where('descripcion', 'Reinscripción  Registro Provincial de Establecimiento')->value('valor');

        $remitente = Remitente::where('user_id', $user->id)->first();
        $existeFacturaPendiente = false;

        if ($remitente) {
            $existeFacturaPendiente = Factura::where('remitentes_id', $remitente->id)
                ->whereHas('nomencladors', function ($query) {
                    $query->where('descripcion', 'Gestión Administrativa');
                })
                ->whereNull('fecha_pago')
                ->exists();
        }

        $existeTramiteModificacionPendiente = false;
        foreach ($redbs as $redb) {
            $existeTramiteModificacionPendiente = $redb->dbtramites()
                ->where('tipo_tramite', 'LIKE', '%MODIFICACION%')
                ->where('estado', '<>', 'APROBADO')
                ->exists();
        }

        $dts = Dbdt::all();

        return view('db.redb.index', compact(
            'redbs', 'idEmpresa', 'dts', 'existeFacturaPendiente',
            'montoInscripcion', 'montoModificacion', 'montoReinscripcion', 'existeTramiteModificacionPendiente'
        ));
    }

    public function create_inscripcion()
    {
        $user_id = auth()->user()->id;
        $dbempresa  = Dbempresa::where('user_id', $user_id)->get();
        $redb = Dbredb::all();
        $dbrubros  = Dbrubro::all();
        $dbbajas  = Dbbaja::all();
        $dbcategorias  = Dbcategoria::all();
        $localidads  = Localidad::all();
        $factura = Factura::where('users_id', $user_id)
                            ->orderBy('fecha_emision', 'desc')
                            ->first();

        return view('db.redb.create_inscripcion')->with(compact('dbempresa', 'redb', 'dbrubros', 'dbbajas', 'dbcategorias', 'localidads', 'factura'));  // formulario nota
    }

    public function store_inscripcion(Request $request)
    {
        // Validaciones
        $request->validate([
            'establecimiento' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            'localidad_id' => 'required|exists:localidads,id',
            'analisis' => 'required|file|mimes:pdf',
            'memoria' => 'required|file|mimes:pdf',
            'habilitacion' => 'required|file|mimes:pdf',
            'contrato' => 'required|file|mimes:pdf',
            'plano' => 'required|file|mimes:pdf',
        ]);
    
        $user = Auth::user();
    
        // Confirmar que la empresa esté correctamente asignada al usuario autenticado
        $empresa = Dbempresa::where('user_id', $user->id)->first();
    
        if (!$empresa) {
            return redirect()->back()->withErrors('No se encontró una empresa asociada al usuario.');
        }

        $factura = Factura::where('users_id', $user->id)
                            ->orderBy('fecha_emision', 'desc')
                            ->first();

        if (!$factura) {
        return redirect()->back()->withErrors('No se encontró una factura asociada al usuario.');
        }
    
        $redb = new Dbredb();
        $redb->establecimiento = $request->input('establecimiento');
        $redb->domicilio = $request->input('domicilio');
        $redb->localidad_id = $request->input('localidad_id');
        $redb->user_id = $user->id;
        $redb->dbempresa_id = $empresa->id;  // Asignar el ID correcto de la empresa
    
        // Guardar el registro de Redb
        $redb->save();
        $idRedb = $redb->id;
    
        // Subida de archivos
        $carpeta = 'empresa/' . $empresa->id . '/redb/' . $idRedb;
    
        $this->guardarArchivo($request, $redb, 'analisis', $carpeta, 'ruta_analisis', 'analisis');
        $this->guardarArchivo($request, $redb, 'memoria', $carpeta, 'ruta_memoria', 'memoria');
        $this->guardarArchivo($request, $redb, 'habilitacion', $carpeta, 'ruta_habilitacion', 'habilitacion');
        $this->guardarArchivo($request, $redb, 'contrato', $carpeta, 'ruta_contrato', 'contrato');
        $this->guardarArchivo($request, $redb, 'plano', $carpeta, 'ruta_plano', 'plano');
        $this->guardarArchivo($request, $redb, 'vinculacion', $carpeta, 'ruta_vinculacion', 'vinculacion');
        $this->guardarArchivo($request, $redb, 'pago', $carpeta, 'ruta_pago', 'pago');
    
        // Guardar rubros, categorías y actividades
/*         $rubros = $request->input('rubro');
        $categorias = $request->input('categoria');
        $actividades = $request->input('actividad');
    
        if (is_array($rubros) && is_array($categorias) && is_array($actividades)) {
            foreach ($rubros as $index => $rubroId) {
                $redb->rubros()->attach($rubroId, [
                    'dbcategoria_id' => $categorias[$index],
                    'actividad' => $actividades[$index]
                ]);
            }
        } */
    
        // Crear un nuevo trámite para la inscripción de Establecimiento
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'INSCRIPCION ESTABLECIMIENTO';
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $empresa->id;
        $tramite->dbredb_id = $idRedb;
        $tramite->factura_id = $factura->id;
    
        // Asignación de área por zona
        if ($redb->localidad && in_array($redb->localidad->zona, ['appm', 'ape', 'apcr'])) {
            $tramite->area = 'AREA PROGRAMATICA';
        } elseif ($redb->localidad && $redb->localidad->zona == 'nc') {
            $tramite->area = 'NIVEL CENTRAL';
        } else {
            $tramite->area = 'ZONA NO DEFINIDA';
        }
    
        $tramite->save();
    
        // Guardar historial del trámite
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha = Carbon::now();
        $dbhistorial->area = $tramite->area;
        $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
        $dbhistorial->observaciones = 'Se envía información y documentación para inicio de inscripción del establecimiento ' . $redb->establecimiento;
        $dbhistorial->user_id = Auth::id();
        $dbhistorial->dbempresa_id = $empresa->id;
        $dbhistorial->dbredb_id = $redb->id;
        $dbhistorial->dbtramite_id = $tramite->id;
        $dbhistorial->save();
    
        $notification = 'El registro fue ingresado correctamente.';
        return redirect('/tramites/index')->with(compact('notification'));
    } 

    public function edit_inscripcion($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id');
        $categoriaIds = $pivotcat->pluck('dbcategoria_id');
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
        
            // Obtener trámite por tramite_id o el más reciente si no se proporciona tramite_id
        $tramiteId = request()->get('tramite_id');
        if ($tramiteId) {
            $tramite = $redb->dbtramites()->where('id', $tramiteId)->first();
            if (!$tramite) {
                \Log::warning("Trámite con ID $tramiteId no encontrado para Redb ID $id.");
                return redirect()->back()->withErrors('El trámite seleccionado no existe.');
            }
        } else {
            $tramite = $redb->dbtramites()->latest()->first();
        }

        $rutaACTA = $redb->ruta_acta;
        $ultimoHistorial = $redb->historial()->latest()->first();
        $dbdts = Dbdt::all();
    
        return view('db.redb.edit_inscripcion', compact('redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 'localidads', 'historial', 'rutaACTA', 'empresa', 'tramite', 'ultimoHistorial', 'dbdts'));
    }
      

    public function update_inscripcion(Request $request, $id)
    {
                // Validaciones
        if (
            in_array($request->input('submitType'), ['aprobar', 'aceptar_area']) &&
            in_array(Auth::user()->role_id, [9, 16, 17, 18])
        ) {
            $request->validate([
                'rubro' => 'required|array|min:1',
                'categoria' => 'required|array|min:1',
                'actividad' => 'required|array|min:1',
            ]);
        }
        if ($request->has('submitType')) {
            $submitType = $request->input('submitType');
            $redb = Dbredb::findOrFail($id);
            $idEmpresa = $redb->dbempresa_id;
            $idRedb = $redb->id;
    
            if ($submitType === 'reenvio_empresa') {
                $user = Auth::user();
                $empresa = Dbempresa::where('user_id', $user->id)->first();
                if (!$empresa) {
                    return redirect()->back()->withErrors('No se encontró una empresa asociada al usuario.');
                }
                $redb = Dbredb::findOrFail($id);
                $redb->establecimiento = $request->input('establecimiento');
                $redb->domicilio = $request->input('domicilio');
                if ($request->has('localidad_id')) {
                    $redb->localidad_id = $request->input('localidad_id');
                } elseif ($request->has('localidad_id_hidden')) {
                    $redb->localidad_id = $request->input('localidad_id_hidden');
                }
                $idRedb = $redb->id;
                $idEmpresa = $redb->dbempresa_id;
    
                if ($request->has('dbdt_id')) {
                    $redb->dbdt_id = $request->input('dbdt_id');
                }
    
                $carpeta = 'empresa/' . $empresa->id . '/redb/' . $idRedb;
    
                $this->guardarArchivo($request, $redb, 'analisis', $carpeta, 'ruta_analisis', 'analisis');
                $this->guardarArchivo($request, $redb, 'memoria', $carpeta, 'ruta_memoria', 'memoria');
                $this->guardarArchivo($request, $redb, 'habilitacion', $carpeta, 'ruta_habilitacion', 'habilitacion');
                $this->guardarArchivo($request, $redb, 'contrato', $carpeta, 'ruta_contrato', 'contrato');
                $this->guardarArchivo($request, $redb, 'plano', $carpeta, 'ruta_plano', 'plano');
                $this->guardarArchivo($request, $redb, 'vinculacion', $carpeta, 'ruta_vinculacion', 'vinculacion');
                $this->guardarArchivo($request, $redb, 'pago', $carpeta, 'ruta_pago', 'pago');
    
                $redb->user_id = Auth::id();
                $redb->save();

                $idRedb = $redb->id;
                $tramite = Dbtramite::where('dbredb_id', $idRedb)->latest()->first();
                $tramite->tipo_tramite = 'INSCRIPCION ESTABLECIMIENTO';
                if (Auth::user()->role_id == 15) {
                    if ($redb->localidad && $redb->localidad->zona == 'nc') {
                        $tramite->area = 'NIVEL CENTRAL';
                    } else {
                        $tramite->area = 'AREA PROGRAMATICA';
                    }
                    $tramite->estado = 'REENVIADO POR EMPRESA';
                } else {
                    $tramite->estado = 'OBSERVADO POR AUTORIDAD SANITARIA';
                    $tramite->area = 'EMPRESA';
                }
                $tramite->save();
    
                $dbhistorial = new Dbhistorial();
                $dbhistorial->fecha = Carbon::now();
                $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
                $dbhistorial->observaciones = $request->input('observaciones');
                $dbhistorial->user_id = Auth::id();
                $dbhistorial->dbempresa_id = $redb->dbempresa_id;
                $dbhistorial->dbredb_id = $redb->id;
    
                if (Auth::user()->role_id == 15) {
                    $dbhistorial->estado = 'REENVIADO POR EMPRESA';
                } else {
                    $dbhistorial->estado = 'OBSERVADO POR AUTORIDAD SANITARIA';
                }
    
                $dbhistorial->area = Auth::user()->role->name;
                $dbhistorial->dbtramite_id = $tramite->id;
                $dbhistorial->save();
    
                $notification = 'El registro fué ACTUALIZADO correctamente.';
                return redirect('/tramites/index')->with(compact('notification'));
    
            } elseif ($submitType === 'devolver') {
                $redb = Dbredb::findOrFail($id);
                $idRedb = $redb->id;
                $idEmpresa = $redb->dbempresa_id;
    
                if ($request->has('dbdt_id')) {
                    $redb->dbdt_id = $request->input('dbdt_id');
                }
                $redb->ruta_acta = null;
                $redb->save();
    
                $tramite = Dbtramite::where('dbredb_id', $idRedb)->latest()->first();
                $tramite->tipo_tramite = 'INSCRIPCION ESTABLECIMIENTO';
                if (Auth::user()->role_id == 15) {
                    if ($redb->localidad && $redb->localidad->zona == 'nc') {
                        $tramite->area = 'NIVEL CENTRAL';
                    } else {
                        $tramite->area = 'AREA PROGRAMATICA';
                    }
                    $tramite->estado = 'REENVIADO POR EMPRESA';
                } elseif (Auth::user()->role_id == 1) {
                    $tramite->estado = 'DEVUELTO A NC';
                    $tramite->area = 'NIVEL CENTRAL';
                } else {
                    if (Auth::user()->role_id == 9) {
                        // Nivel Central devuelve según zona
                        if ($redb->localidad && $redb->localidad->zona == 'nc') {
                            $tramite->estado = 'DEVUELTO A EMPRESA';
                            $tramite->area = 'EMPRESA';
                        } else {
                            $tramite->estado = 'DEVUELTO A AREA PROGRAMATICA';
                            $tramite->area = 'AREA PROGRAMATICA';
                        }
                    } else {
                        // Evaluadores de áreas devuelven a empresa
                        $tramite->estado = 'OBSERVADO POR AUTORIDAD SANITARIA';
                        $tramite->area = 'EMPRESA';
                    }
                }
                $tramite->save();
    
                $dbhistorial = new Dbhistorial();
                $dbhistorial->fecha = Carbon::now();
                $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
                $dbhistorial->observaciones = $request->input('observaciones');
                $dbhistorial->user_id = Auth::id();
                $dbhistorial->dbempresa_id = $redb->dbempresa_id;
                $dbhistorial->dbredb_id = $redb->id;
    
                if (Auth::user()->role_id == 15) {
                    $dbhistorial->estado = 'REENVIADO POR EMPRESA';
                } elseif (Auth::user()->role_id == 9) {
                    if ($redb->localidad && $redb->localidad->zona == 'nc') {
                        $dbhistorial->estado = 'DEVUELTO A EMPRESA';
                    } else {
                        $dbhistorial->estado = 'DEVUELTO A AREA PROGRAMATICA';
                    }
                } else {
                    $dbhistorial->estado = 'OBSERVADO POR AUTORIDAD SANITARIA';
                }
    
                $dbhistorial->area = Auth::user()->role->name;
                $dbhistorial->dbtramite_id = $tramite->id;
                $dbhistorial->save();
    
                $notification = 'El registro fué ACTUALIZADO correctamente.';
                return redirect('/tramites/index')->with(compact('notification'));
    
            } elseif ($submitType === 'aceptar_area') {
                $redb = Dbredb::findOrFail($id);
                $redb->rubros()->detach();
    
                $rubros = $request->input('rubro');
                $categorias = $request->input('categoria');
                $actividades = $request->input('actividad');

                if (!$rubros || !is_array($rubros)) {
                    return back()->withErrors(['Debe agregar al menos un rubro antes de enviar el formulario.'])->withInput();
                }   
                foreach ($rubros as $index => $rubroId) {
                    $categoriaActual = $categorias[$index];
                    $actividadActual = $actividades[$index];
                    $redb->rubros()->attach($rubroId, [
                        'dbcategoria_id' => $categoriaActual,
                        'actividad' => $actividadActual
                    ]);
                }
                $idEmpresa = $redb->dbempresa_id;
                $idRedb = $redb->id;
    
                if ($request->hasFile('acta')) {
                    $actaArchivo = $request->file('acta');
                    $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb;
    
                    if (!Storage::exists($carpeta)) {
                        Storage::makeDirectory($carpeta);
                    }
    
                    $identificacion = date('dmY') . '_acta_' . $request->input('establecimiento') . '.' . $actaArchivo->getClientOriginalExtension();
                    $rutaACTA = Storage::disk('local')->putFileAs($carpeta, $actaArchivo, $identificacion);
    
                    $redb->ruta_acta = $rutaACTA;
                    if ($request->has('dbdt_id')) {
                        $redb->dbdt_id = $request->input('dbdt_id');
                    }
                    $redb->save();
                } else {
                    return redirect()->back()->withErrors('El archivo de acta es obligatorio.');
                }
    
                $tramite = Dbtramite::where('dbredb_id', $idRedb)->latest()->first();
                $tramite->estado = 'EVALUADO POR AREA PROGRAMATICA';
                $tramite->area = 'NIVEL CENTRAL';
                $tramite->save();
    
                $dbhistorial = new Dbhistorial();
                $dbhistorial->fecha = Carbon::now();
                $user = Auth::user();
                $dbhistorial->area = $user->role->name;
                $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
                $dbhistorial->estado = 'EVALUADO POR AREA PROGRAMATICA';
                $dbhistorial->observaciones = $request->input('observaciones');
                $dbhistorial->user_id = Auth::id();
                $dbhistorial->dbempresa_id = $redb->dbempresa_id;
                $dbhistorial->dbredb_id = $redb->id;
                $dbhistorial->dbtramite_id = $tramite->id;
                $dbhistorial->save();
    
                $notification = 'El registro fue ACTUALIZADO correctamente.';
                return redirect('/tramites/index')->with(compact('notification'));

            } elseif ($submitType === 'aprobar') {
                $redb = Dbredb::findOrFail($id);
                $redb->rubros()->detach();
    
                $rubros = $request->input('rubro');
                $categorias = $request->input('categoria');
                $actividades = $request->input('actividad');
            
                if (is_array($rubros) && is_array($categorias) && is_array($actividades)) {
                    foreach ($rubros as $index => $rubroId) {
                        $redb->rubros()->attach($rubroId, [
                            'dbcategoria_id' => $categorias[$index],
                            'actividad' => $actividades[$index]
                        ]);
                    }
                }
                $idEmpresa = $redb->dbempresa_id;
                $idRedb = $redb->id;
            
                // Verifica si se ha subido el archivo 'acta'
                if ($request->hasFile('acta')) {
                    $actaArchivo = $request->file('acta');
                    $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb;
            
                    if (!Storage::exists($carpeta)) {
                        Storage::makeDirectory($carpeta);
                    }
            
                    $identificacion = date('dmY') . '_acta_' . $request->input('establecimiento') . '.' . $actaArchivo->getClientOriginalExtension();
                    $rutaACTA = Storage::disk('local')->putFileAs($carpeta, $actaArchivo, $identificacion);
            
                    $redb->ruta_acta = $rutaACTA;
                }
            
                // Guarda el valor de `dbdt_id` si está presente en la solicitud
                if ($request->has('dbdt_id')) {
                    $redb->dbdt_id = $request->input('dbdt_id');
                }
                
                $redb->save();
            
                // Actualizar el estado y el área del trámite
                $tramite = Dbtramite::where('dbredb_id', $idRedb)->latest()->first();
                $tramite->estado = 'APROBADO';
                $tramite->area = 'JEFATURA';
                $tramite->save();
            
                // Crear el historial del trámite
                $dbhistorial = new Dbhistorial();
                $dbhistorial->fecha = Carbon::now();
                $user = Auth::user();
                $dbhistorial->area = $user->role->name;
                $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
                $dbhistorial->estado = 'APROBADO';
                $dbhistorial->observaciones = $request->input('observaciones');
                $dbhistorial->user_id = Auth::id();
                $dbhistorial->dbempresa_id = $redb->dbempresa_id;
                $dbhistorial->dbredb_id = $redb->id;
                $dbhistorial->dbtramite_id = $tramite->id;
                $dbhistorial->save();
            
                $notification = 'El registro fue ACTUALIZADO correctamente.';
                return redirect('/tramites/index')->with(compact('notification'));
            } elseif ($submitType === 'inscribir') {
                $redb = Dbredb::findOrFail($id);
                $idEmpresa = $redb->dbempresa_id;
                $idRedb = $redb->id;
                // Obtener el valor máximo actual del campo 'numero' para registros de tránsito provincial
                $maxNumero = Dbredb::where('transito', 'PROVINCIAL')->max('numero');
                // Calcular el siguiente número: si existe un número máximo, le suma 1; si no, comienza en 1
                $redb->numero = ($maxNumero !== null && $maxNumero > 0) ? $maxNumero + 1 : 1;
                $redb->fecha_inscripcion = Carbon::now();
                $redb->fecha_reinscripcion = Carbon::now()->addYears(5)->toDateString();
                $redb->finalizado = "1";
                $redb->expediente = $request->input('expediente');
                $redb->transito = "PROVINCIAL";
                $redb->save();
    
                $tramite = Dbtramite::where('dbredb_id', $idRedb)->latest()->first();
                $tramite->estado = 'INSCRIPTO';
                $tramite->area = 'REGISTRO';
                $tramite->finalizado = "1";
                $tramite->save();
    
                $dbhistorial = new Dbhistorial();
                $dbhistorial->fecha = Carbon::now();
                $user = Auth::user();
                $dbhistorial->area = $user->role->name;
                $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO';
                $dbhistorial->estado = 'INSCRIPTO';
                $dbhistorial->observaciones = $request->input('observaciones');
                $dbhistorial->user_id = Auth::id();
                $dbhistorial->dbempresa_id = $redb->dbempresa_id;
                $dbhistorial->dbredb_id = $redb->id;
                $dbhistorial->dbtramite_id = $tramite->id;
                $dbhistorial->save();
    
                $notification = 'El registro fue ACTUALIZADO correctamente.';
                return redirect('/tramites/index')->with(compact('notification'));
            }
        }
    }    

    public function create_modificacion($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
        $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
        $tramite = Dbtramite::where('dbredb_id', $id)->latest()->first();
        $rutaACTA = $redb->ruta_acta;
        $dbdts = Dbdt::all();
    
        // Obtener el remitente asociado al usuario actual
        $remitente = Remitente::where('user_id', $user->id)->first();
        $existeFacturaPendiente = false;
    
        if ($remitente) {
            $existeFacturaPendiente = Factura::where('remitentes_id', $remitente->id)
                ->whereHas('nomencladors', function ($query) {
                    $query->where('descripcion', 'Gestión Administrativa'); // Ajusta según la descripción de tu item
                })
                ->whereNull('fecha_pago') // Factura pendiente de pago
                ->exists();
        }

        $PendienteModificacion = $redb->dbtramites()
            ->where('tipo_tramite', 'LIKE', '%MODIFICACION%')
            ->where('estado', '<>', 'APROBADO')
            ->exists();
    
        return view('db.redb.create_modificacion', compact(
            'redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 
            'localidads', 'historial', 'rutaACTA', 'empresa', 'tramite', 
            'dbdts', 'existeFacturaPendiente', 'PendienteModificacion'
        ));
    }      

    public function store_modificacion(Request $request, $id)
    {
        $user = Auth::user();
        
        // Obtener el registro de Dbredb usando el ID del formulario
        $redb = Dbredb::findOrFail($id);
        
        // Validar el formulario
        $request->validate([
            'establecimiento' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            //'localidad_id' => 'required|exists:localidads,id',
            'analisis' => 'nullable|file|mimes:pdf',
            'memoria' => 'nullable|file|mimes:pdf',
            'habilitacion' => 'nullable|file|mimes:pdf',
            'contrato' => 'nullable|file|mimes:pdf',
            'plano' => 'nullable|file|mimes:pdf',
            'vinculacion' => 'nullable|file|mimes:pdf',
        ]);
    
        // Obtener dbempresa_id
        $empresa = $user->empresa()->first();
        $empresa_id = $empresa ? $empresa->id : null;
    
        if (!$empresa_id) {
            return redirect()->back()->withErrors('Error: No se encontró una empresa asociada al usuario.');
        }
    
        // Actualizar datos de `Dbredb`
        $redb->establecimiento = $request->input('establecimiento');
        $redb->domicilio = $request->input('domicilio');
        // Check manually for localidad_id or fallback
        if (!$request->input('localidad_id') && !$request->input('localidad_id_hidden')) {
            return redirect()->back()->withErrors('Localidad es requerida.');
        }

        // Set localidad_id using either the selected or hidden field
        $redb->localidad_id = $request->input('localidad_id') ?? $request->input('localidad_id_hidden');
        $redb->finalizado = null;
    
        // Guardar archivos subidos
        $archivos = ['analisis', 'memoria', 'habilitacion', 'contrato', 'plano', 'vinculacion', 'pago'];
        foreach ($archivos as $archivo) {
            if ($request->hasFile($archivo)) {
                $file = $request->file($archivo);
                $carpeta = 'empresa/' . $empresa_id . '/redb/' . $redb->id;
                $nombreArchivo = date('dmY') . "_{$archivo}_" . $request->input('establecimiento') . '.' . $file->getClientOriginalExtension();
                $ruta = $file->storeAs($carpeta, $nombreArchivo);
                $redb->{"ruta_{$archivo}"} = $ruta;
            }
        }
        // Guardar cambios en redb
        $redb->user_id = Auth::id();
        // Guardar cambios en Dbredb
        $redb->save();
        // Eliminar todas las relaciones actuales
        $redb->rubros()->detach();
        // Eliminar y reasignar rubros solo si NO es PRODUCTOR
        if ($user->role_id != 15) {
            $redb->rubros()->detach();

            $rubros = $request->input('rubro');
            $categorias = $request->input('categoria');
            $actividades = $request->input('actividad');

            if (is_array($rubros) && is_array($categorias) && is_array($actividades)) {
                foreach ($rubros as $index => $rubroId) {
                    $categoriaActual = $categorias[$index] ?? null;
                    $actividadActual = $actividades[$index] ?? null;

                    $redb->rubros()->attach($rubroId, [
                        'dbcategoria_id' => $categoriaActual,
                        'actividad' => $actividadActual
                    ]);
                }
            }
        }
        // Crear nuevo tramite de modificación en Dbtramite
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'MODIFICACION ESTABLECIMIENTO - ' . $redb->establecimiento;
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $empresa_id;
        $tramite->dbredb_id = $redb->id;
        $tramite->save();
    
        // Crear historial del trámite en Dbhistorial
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = 'EMPRESA';
        $historial->motivo = 'MODIFICACION ESTABLECIMIENTO - ' . $redb->establecimiento;
        $historial->estado = 'SOLICITUD DE MODIFICACION';
        $historial->observaciones = $request->input('observaciones');
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $empresa_id;
        $historial->dbredb_id = $redb->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        // Notificación de éxito y redirección
        $notification = 'El registro fue actualizado y la modificación se ingresó correctamente.';
        return redirect()->route('db_tramites_index')->with(compact('notification'));
    }
    
    public function show($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
        $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
        $rutaACTA = $redb->ruta_acta;
        $tramite = Dbtramite::where('dbredb_id', $id)->latest()->first();
        $dt = Dbdt::with('redbs')->find($redb->dbdt_id);
        return view('db.redb.show', compact('redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 'localidads', 'historial', 'rutaACTA', 'empresa', 'tramite', 'dt'));
    }

    public function edit_modificacion(Request $request, $id)
    {
        $redb = Dbredb::findOrFail($id);
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
        $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
            // Capturar el ID del trámite desde la URL
        $tramiteId = $request->get('tramite_id');
        
            // Obtener el trámite correspondiente al ID
        $tramite = Dbtramite::find($tramiteId); 
        $rutaACTA = $redb->ruta_acta;
        $ultimoHistorial = $tramite ? $tramite->historial()->latest()->first() : null;
        $dbdts = Dbdt::all();
        return view('db.redb.edit_modificacion', compact('redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 'localidads', 'historial', 'rutaACTA', 'empresa', 'ultimoHistorial', 'tramite'));
    }

    public function update_modificacion(Request $request, $id)
    {
        if ($request->has('submitType')) {
            $submitType = $request->input('submitType');
            $redb = Dbredb::findOrFail($id);
            $idEmpresa = $redb->dbempresa_id;
            $idRedb = $redb->id;
    
            // Obtener observaciones del formulario
            $observaciones = $request->input('observaciones', '');
    
            // Actualización de datos generales
            $redb->establecimiento = $request->input('establecimiento');
            $redb->domicilio = $request->input('domicilio');
            $redb->localidad_id = $request->input('localidad_id') ?? $request->input('localidad_id_hidden');
            $redb->dbdt_id = $request->input('dbdt_id');
    
            // Guardar archivos subidos usando el método centralizado `uploadFile`
            $archivos = ['analisis', 'memoria', 'contrato', 'habilitacion', 'plano', 'vinculacion', 'pago', 'acta'];
            foreach ($archivos as $archivo) {
                $this->uploadFile($request, $archivo, $redb, $idEmpresa, $idRedb);
            }
    
            // Actualización de rubros y categorías
            $this->updateRubrosCategorias($request, $redb);
            $redb->fecha_modificacion = Carbon::now();
            $redb->save();
    
            // Manejo de los distintos tipos de envíos
            if ($submitType === 'enviar_nc') {
                $this->actualizarTramite($redb, 'ENVIADO A NC', 'NIVEL CENTRAL', $observaciones);
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite enviado a NC correctamente.');
            } elseif ($submitType === 'devolver_empresa' && in_array(Auth::user()->role_id, [9, 16, 17, 18])) {
                $this->actualizarTramite($redb, 'DEVUELTO', 'EMPRESA', $observaciones);
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite devuelto a la empresa.');
            } elseif ($submitType === 'devolver_area') {
                $this->actualizarTramite($redb, 'DEVUELTO A AREA PROGRAMATICA', 'AREA PROGRAMATICA', $observaciones);
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite devuelto al área programática.');
            } elseif ($submitType === 'modifica_empresa') {
                $this->actualizarTramite($redb, 'REENVIADO POR EMPRESA', 'EMPRESA', $observaciones);
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite reenviado para su tratamiento.');
            } elseif ($submitType === 'aprobar') {
                $this->actualizarTramite($redb, 'APROBADO', 'NIVEL CENTRAL', $observaciones);
                // Actualizar el campo 'finalizado' en el registro de $redb
                $redb->finalizado = "1";
                $redb->save(); // Guardar los cambios en la base de datos
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite aprobado y finalizado.');
            } elseif ($submitType === 'evaluar') {
                $this->actualizarTramite($redb, 'EVALUADO POR AREA PROGRAMATICA', 'NIVEL CENTRAL', $observaciones);
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite evaluado correctamente por Area Programática.');
            } elseif ($submitType === 'modificar') {
                $this->actualizarTramite($redb, 'MODIFICADO', 'NIVEL CENTRAL', 'Modificación del establecimiento.');
                return redirect()->route('db_tramites_index')->with('notification', 'Trámite de modificación realizado correctamente.');
        } else {
                $notification = 'No se realizaron modificaciones, revisa la información o los archivos.';
                return redirect('/tramites/index')->with(compact('notification'));
            }
        }
    }
    
    private function guardarArchivo($request, $model, $inputName, $folder, $fieldName, $label)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
    
            // Crear carpeta si no existe
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder);
            }
    
            $fileName = date('dmY') . "_{$label}_" . $request->input('establecimiento') . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('local')->putFileAs($folder, $file, $fileName);
    
            // Actualizar el campo correspondiente en el modelo
            $model->{$fieldName} = $path;
            $model->save();
        }
    }   
    private function actualizarTramite($redb, $estado, $area, $observaciones)
    {
        $tramite = Dbtramite::where('dbredb_id', $redb->id)->latest()->first();
        $tramite->estado = $estado;
        $tramite->area = $area;
        $tramite->save();
    
        $this->registrarHistorial($tramite, $redb, $estado, $observaciones);
    }

    private function registrarHistorial($tramite, $redb, $estado, $observaciones)
    {
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = Auth::user()->role->name;
        $historial->motivo = 'MODIFICACION ESTABLECIMIENTO - ' . $redb->establecimiento;
        $historial->estado = $estado;
        $historial->observaciones = $observaciones;
        $historial->user_id = Auth::id();
        $historial->dbempresa_id = $redb->dbempresa_id;
        $historial->dbredb_id = $redb->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    }

    private function uploadFile($request, $fieldName, $redb, $idEmpresa, $idRedb)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb;
    
            // Crear la carpeta si no existe
            if (!Storage::exists($carpeta)) {
                Storage::makeDirectory($carpeta);
            }
    
            $timestamp = Carbon::now()->format('Ymd_His');
            $filename = "{$timestamp}_{$fieldName}_" . Str::slug($redb->establecimiento) . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('local')->putFileAs($carpeta, $file, $filename);
    
            // Asigna la ruta específica al atributo del modelo, siguiendo la lógica previa
            $redb->{'ruta_' . $fieldName} = $path;
            // Guarda solo la ruta actualizada en lugar de guardar en cada iteración
            $redb->save();
        }
    }
    

    public function adjuntarDocumentos(Request $request, $dbredb_id) 
    {
        // Validación y almacenamiento de los documentos adjuntos
        $request->validate([
            'contrato' => 'required|file|mimes:pdf,docx|max:2048', // Ajusta las reglas de validación según tus necesidades
            'habilitacion' => 'required|file|mimes:pdf,docx|max:2048',
            'plano' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $dbredb = Dbredb::find($dbredb_id);

        if (!$dbredb) {
            // Maneja el caso en el que no se encuentra el registro Dbredb
        }

        // Subir el documento de Contrato
        if ($request->hasFile('contrato')) {
            $contrato = $request->file('contrato');
            $contratoNombre = $contrato->getClientOriginalName();
            $contrato->storeAs('documentos', $contratoNombre, 'public'); // Almacena el contrato en la carpeta 'public/documentos'
            $dbredb->contrato = 'documentos/' . $contratoNombre;
        }

        // Repite el proceso para los documentos de Habilitación y Plano de manera similar.

        // Guarda el registro Dbredb con los datos actualizados.
        $dbredb->save();

        return redirect()->back()->with('notification', 'Documentos adjuntados con éxito.');
    }

    public function getCategorias($id)
    {
        $categorias = Dbcategoria::where('dbrubro_id', $id)->get();
        return response()->json($categorias);
    }

    private function updateRubrosCategorias($request, $redb)
    {
        $redb->rubros()->detach();
    
        $rubros = $request->input('rubro', []);
        $categorias = $request->input('categoria', []);
        $actividades = $request->input('actividad', []);
    
        foreach ($rubros as $index => $rubroId) {
            $categoriaActual = $categorias[$index] ?? null;
            $actividadActual = $actividades[$index] ?? null;
    
            $redb->rubros()->attach($rubroId, [
                'dbcategoria_id' => $categoriaActual,
                'actividad' => $actividadActual
            ]);
        }
    }

    public function create_reinscripcion($id)
    {
        $redb = Dbredb::findOrFail($id);
        $user_id = $redb->id;
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
        $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
        $tramite = Dbtramite::where('dbredb_id', $id)->latest()->first();
        $rutaACTA = $redb->ruta_acta;
        $dbdts = Dbdt::all();
    
        // Obtener el remitente asociado al usuario actual
        $remitente = Remitente::where('user_id', $user->id)->first();
        $existeFacturaPendiente = false;
    
        if ($remitente) {
            $existeFacturaPendiente = Factura::where('remitentes_id', $remitente->id)
                ->whereHas('nomencladors', function ($query) {
                    $query->where('descripcion', 'Gestión Administrativa'); // Ajusta según la descripción de tu item
                })
                ->whereNull('fecha_pago') // Factura pendiente de pago
                ->exists();
        }

        $PendienteModificacion = $redb->dbtramites()
            ->where('tipo_tramite', 'LIKE', '%REINSCRIPCION%')
            ->where('estado', '<>', 'APROBADO')
            ->exists();
        $factura = Factura::where('users_id', $user_id)
            ->orderBy('fecha_emision', 'desc')
            ->first();
    
        return view('db.redb.create_reinscripcion', compact(
            'redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 
            'localidads', 'historial', 'rutaACTA', 'empresa', 'tramite', 
            'dbdts', 'existeFacturaPendiente', 'PendienteModificacion', 'factura'
        ));
    }      

    public function store_reinscripcion(Request $request, $id)
    {
        $user = Auth::user();
        
        // Obtener el registro de Dbredb usando el ID del formulario
        $redb = Dbredb::findOrFail($id);
        
        // Validar el formulario
        $request->validate([
            'establecimiento' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            //'localidad_id' => 'required|exists:localidads,id',
            'analisis' => 'nullable|file|mimes:pdf',
            'memoria' => 'nullable|file|mimes:pdf',
            'habilitacion' => 'nullable|file|mimes:pdf',
            'contrato' => 'nullable|file|mimes:pdf',
            'plano' => 'nullable|file|mimes:pdf',
            'vinculacion' => 'nullable|file|mimes:pdf',
        ]);
    
        // Obtener dbempresa_id
        $empresa = $user->empresa()->first();
        $empresa_id = $empresa ? $empresa->id : null;
    
        if (!$empresa_id) {
            return redirect()->back()->withErrors('Error: No se encontró una empresa asociada al usuario.');
        }

        $factura = Factura::where('users_id', $user->id)
                            ->orderBy('fecha_emision', 'desc')
                            ->first();

        if (!$factura) {
        return redirect()->back()->withErrors('No se encontró una factura asociada al usuario.');
        }
    
        // Actualizar datos de `Dbredb`
        $redb->establecimiento = $request->input('establecimiento');
        $redb->domicilio = $request->input('domicilio');
        // Check manually for localidad_id or fallback
        if (!$request->input('localidad_id') && !$request->input('localidad_id_hidden')) {
            return redirect()->back()->withErrors('Localidad es requerida.');
        }

        // Set localidad_id using either the selected or hidden field
        $redb->localidad_id = $request->input('localidad_id') ?? $request->input('localidad_id_hidden');
        $redb->finalizado = null;
    
        // Guardar archivos subidos
        $archivos = ['analisis', 'memoria', 'habilitacion', 'contrato', 'plano', 'vinculacion', 'pago'];
        foreach ($archivos as $archivo) {
            if ($request->hasFile($archivo)) {
                $file = $request->file($archivo);
                $carpeta = 'empresa/' . $empresa_id . '/redb/' . $redb->id;
                $nombreArchivo = date('dmY') . "_{$archivo}_" . $request->input('establecimiento') . '.' . $file->getClientOriginalExtension();
                $ruta = $file->storeAs($carpeta, $nombreArchivo);
                $redb->{"ruta_{$archivo}"} = $ruta;
            }
        }
        // Guardar cambios en redb
        $redb->user_id = Auth::id();
        // Guardar cambios en Dbredb
        $redb->save();
        // Eliminar todas las relaciones actuales
        $redb->rubros()->detach();
        // Nuevas relaciones
        $rubros = $request->input('rubro');
        $categorias = $request->input('categoria');
        $actividades = $request->input('actividad');
        
        foreach ($rubros as $index => $rubroId) {
            $categoriaActual = $categorias[$index];
            $actividadActual = $actividades[$index];
        
            // Utilizar attach para agregar la nueva relación
            $redb->rubros()->attach($rubroId, [
                'dbcategoria_id' => $categoriaActual,
                'actividad' => $actividadActual
            ]);
        }
        // Crear nuevo tramite de modificación en Dbtramite
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'REINSCRIBIR ESTABLECIMIENTO - ' . $redb->establecimiento;
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $empresa_id;
        $tramite->dbredb_id = $redb->id;
        $tramite->save();
    
        // Crear historial del trámite en Dbhistorial
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = 'EMPRESA';
        $historial->motivo = 'REINSCRIBIR ESTABLECIMIENTO - ' . $redb->establecimiento;
        $historial->estado = 'SOLICITUD DE MODIFICACION';
        $historial->observaciones = $request->input('observaciones');
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $empresa_id;
        $historial->dbredb_id = $redb->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        // Notificación de éxito y redirección
        $notification = 'El registro fue actualizado y la modificación se ingresó correctamente.';
        return redirect()->route('db_tramites_index')->with(compact('notification'));
    }

    public function edit_reinscripcion(Request $request, $id)
    {
        $redb = Dbredb::findOrFail($id);
        $rubros = Dbrubro::with('categorias')->get();
        $dbbajas = Dbbaja::all();
        $user = Auth::user();
        $empresa = $user->empresa;
        $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
        $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
        $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
        $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
        $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
        $localidads = Localidad::all();
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
            // Capturar el ID del trámite desde la URL
        $tramiteId = $request->get('tramite_id');

        // Obtener el trámite correspondiente al ID
        $tramite = $tramiteId ? Dbtramite::find($tramiteId) : null;

        // Manejar el caso en que no se encuentra el trámite
        if (!$tramite) {
            \Log::warning("No se encontró un trámite para el ID proporcionado: $tramiteId.");
            $tramite = null; // Si lo necesitas explícitamente como `null`
        }
        $rutaACTA = $redb->ruta_acta;
        $ultimoHistorial = $tramite ? $tramite->historial()->latest()->first() : null;
        $dbdts = Dbdt::all();
        return view('db.redb.edit_reinscripcion', compact('redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 'localidads', 'historial', 'rutaACTA', 'empresa', 'ultimoHistorial', 'tramite'));
    }
 

    public function update_reinscripcion(Request $request, $id)
    {
        $redb = Dbredb::findOrFail($id);
        $idEmpresa = $redb->dbempresa_id;
        $idRedb = $redb->id;
    
        $observaciones = $request->input('observaciones', '');
    
        // Subir archivos
        $archivos = ['analisis', 'memoria', 'contrato', 'habilitacion', 'plano', 'vinculacion', 'pago', 'acta'];
        foreach ($archivos as $archivo) {
            $this->uploadFile($request, $archivo, $redb, $idEmpresa, $idRedb);
        }
    
        // Actualizar rubros y categorías
        $this->updateRubrosCategorias($request, $redb);
        $redb->save();
    
        // Manejo de envíos basado en submitType
        $submitType = $request->input('submitType');
        switch ($submitType) {
            case 'enviar_nc':
                $this->actualizarTramite($redb, 'ENVIADO A NC', 'NIVEL CENTRAL', $observaciones);
                $notification = 'Trámite enviado a NC correctamente.';
                break;
    
            case 'devolver_empresa':
                $this->actualizarTramite($redb, 'DEVUELTO', 'EMPRESA', $observaciones);
                $notification = 'Trámite devuelto a la empresa.';
                break;
    
            case 'devolver_area':
                $this->actualizarTramite($redb, 'DEVUELTO A AREA PROGRAMATICA', 'AREA PROGRAMATICA', $observaciones);
                $notification = 'Trámite devuelto al área programática.';
                break;
    
            case 'modifica_empresa':
                $this->actualizarTramite($redb, 'REENVIADO POR EMPRESA', 'EMPRESA', $observaciones);
                $notification = 'Trámite reenviado para su tratamiento.';
                break;
    
                case 'reinscribir':                  
                    $this->actualizarTramite($redb, 'REINSCRIPTO', 'NIVEL CENTRAL', $observaciones);
                    // Determinar la fecha base
                    $fechaBase = $redb->fecha_reinscripcion 
                    ? Carbon::parse($redb->fecha_reinscripcion) // Si existe fecha de reinscripción previa, úsala
                    : ($redb->fecha_inscripcion 
                        ? Carbon::parse($redb->fecha_inscripcion) // Si no, usa la fecha de inscripción
                        : Carbon::now()); // Si no hay ninguna, usa la fecha actual como último recurso

                    // Calcular la nueva fecha de reinscripción
                    $redb->fecha_reinscripcion = $fechaBase->addYears(5)->toDateString();

                    $redb->finalizado = "1";
                    $redb->expediente = $request->input('expediente');
                    $redb->save();
                    $notification = 'Trámite aprobado y finalizado.';
                    break;
    
            case 'evaluar':
                $this->actualizarTramite($redb, 'EVALUADO POR AREA PROGRAMATICA', 'NIVEL CENTRAL', $observaciones);
                $notification = 'Trámite evaluado correctamente por Área Programática.';
                break;
    
            default:
                $notification = 'No se realizaron modificaciones.';
                break;
        }
    
        return redirect()->route('db_tramites_index')->with('notification', $notification);
    }
    
    public function verDNI($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_dni);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    
    public function verCUIT($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_cuit);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    
    public function verANALISIS($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_analisis);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

    public function verMEMORIA($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_memoria);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    
    public function verCONTRATO($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_contrato);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

    public function verHAB($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_habilitacion);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    
    public function verPLANO($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_plano);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

    public function verVINCDT($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_vinculacion);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

    public function verPAGO($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_pago);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    
    public function verACTA($id)
    {
        $redb = Dbredb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$redb->ruta_acta);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

/*     public function baja($id)
    {
        $redb = Dbredb::findOrFail($id);
        $user = Auth::user();
        $empresa = $user->empresa;
        $dbempresa  = $redb->empresa->id;
        $tramite = Dbtramite::where('dbredb_id', $redb->id)->latest()->first();

        return view('db.redb.baja')->with(compact('dbempresa', 'redb', 'tramite'));  // formulario nota
    } */

    public function create_baja($id)
    {
        $redb = Dbredb::findOrFail($id);
        $user = Auth::user();
        $empresa = $user->empresa;
        $dbempresa  = $redb->empresa->id;
        $tramite = Dbtramite::where('dbredb_id', $redb->id)->latest()->first();

        return view('db.redb.create_baja')->with(compact('dbempresa', 'redb', 'tramite'));  // formulario nota
    }

    public function store_baja(Request $request, $id)
    {
        $redb = Dbredb::with('dbrpadbs')->findOrFail($id);

        // Generar número consecutivo para la tabla dbbajas
        $numero_siguiente = Dbbaja::max('numero') + 1 ?? 1;

        // Crear la nueva baja
        $dbbaja = new Dbbaja();
        $dbbaja->numero = $numero_siguiente;
        $dbbaja->fecha_baja = Carbon::now();
        $dbbaja->caja = $request->input('caja');
        $dbbaja->motivo = $request->input('motivo');
        $dbbaja->expediente = $request->input('expediente');
        $dbbaja->nro_registro = $redb->numero;
        $dbbaja->establecimiento = $redb->establecimiento;
        $dbbaja->solicito = $request->input('solicito');
        $dbbaja->user_id = Auth::id();
        $dbbaja->save();

        // Asociar la baja al redb
        $redb->dbbaja_id = $dbbaja->id;
        $redb->fecha_baja = Carbon::now();
        $redb->save();

        // ➕ Dar de baja también los productos asociados
        foreach ($redb->dbrpadbs as $producto) {
            $producto->dbbaja_id = $dbbaja->id;
            $producto->save();
        }

        // Actualizar trámite relacionado
        $tramite = Dbtramite::where('dbredb_id', $redb->id)->latest()->first();
        if ($tramite) {
            $tramite->estado = 'FINALIZADO';
            $tramite->finalizado = 1;
            $tramite->save();
        }

        return redirect()->route('db_tramites_index')->with('notification', 'La baja fue ingresada correctamente.');
    }   

    public function solicitar_baja(Request $request, $redb)
    {
        $user = Auth::user();

        // Busca el registro de Dbredb usando el ID capturado en la ruta
        $redb = Dbredb::find($redb);
        if (!$redb) {
            return redirect()->back()->withErrors('No se encontró el establecimiento seleccionado.');
        }

        // Crea un nuevo tramite de inscripción de Establecimiento
        $idEmpresa = $redb->empresa->id;
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'BAJA ESTABLECIMIENTO - ' . $redb->establecimiento;
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $idEmpresa;
        $tramite->dbredb_id = $redb->id; // Obtener el ID del registro de redb
        $tramite->observaciones = $request->input('observaciones');
        $tramite->save();

        // Guardar historial de la baja
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha = Carbon::now();
        $dbhistorial->area = 'EMPRESA';
        $dbhistorial->motivo = 'BAJA ESTABLECIMIENTO - ' . $redb->establecimiento;
        $dbhistorial->observaciones = 'Se solicita la baja del establecimiento ' . $redb->establecimiento;
        $dbhistorial->user_id = Auth::id();
        $dbhistorial->dbempresa_id = $idEmpresa;
        $dbhistorial->dbredb_id = $redb->id;
        $dbhistorial->dbtramite_id = $tramite->id; 
        $dbhistorial->save();

        // Redireccionar con mensaje de éxito
        
        $notification = 'El trámite de baja fue iniciado correctamente.';
        return redirect('/tramites/index')->with(compact('notification'));
    }

    public function reinscripcion($redb_id)
    {
        \Log::info("Iniciando creación de trámite de reinscripción para REDB ID: $redb_id");
    
        $user = Auth::user();
        $redb = Dbredb::findOrFail($redb_id);
        $idEmpresa = $user->empresa()->value('id');
    
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'REINSCRIBIR ESTABLECIMIENTO - ' . $redb->establecimiento;
        $tramite->estado = 'INICIADO';
        $tramite->area = 'AUTORIDAD SANITARIA';
        $tramite->observaciones = 'Solicitud de reinscripción';
        $tramite->dbempresa_id = $idEmpresa;
        $tramite->dbredb_id = $redb->id;
    
        $respuestaTramite = $tramite->save();
        $respuestaHistorial = false;
    
        if ($respuestaTramite) {
            \Log::info("Trámite de reinscripción creado con ID: " . $tramite->id);
    
            $dbhistorial = new Dbhistorial();
            $dbhistorial->fecha = Carbon::now();
            $dbhistorial->area = 'AUTORIDAD SANITARIA';
            $dbhistorial->motivo = 'REINSCRIBIR ESTABLECIMIENTO - ' . $redb->establecimiento;
            $dbhistorial->observaciones = 'Se solicita la reinscripción del establecimiento ' . $redb->establecimiento;
            $dbhistorial->user_id = Auth::id();
            $dbhistorial->dbempresa_id = $idEmpresa;
            $dbhistorial->dbredb_id = $redb->id;
            $dbhistorial->dbtramite_id = $tramite->id;
    
            $respuestaHistorial = $dbhistorial->save();
    
            if ($respuestaHistorial) {
                \Log::info("Historial para el trámite de reinscripción creado con ID: " . $dbhistorial->id);
            } else {
                \Log::error("Error al guardar el historial para el trámite de reinscripción de REDB ID: $redb_id");
            }
        } else {
            \Log::error("Error al guardar el trámite de reinscripción para REDB ID: $redb_id");
        }
    
        $notification = $respuestaTramite && $respuestaHistorial ? 'Trámite de reinscripción creado correctamente.' : 'Error al crear trámite de reinscripción.';
        $class = $respuestaTramite && $respuestaHistorial ? 'success' : 'error';
    
        return redirect()->route('db_tramites_index')
            ->with(['notification' => $notification, 'class' => $class]);
    }   
    
    public function certificado($id)
    {
        // Configuración global de localización
        setlocale(LC_TIME, 'es_ES.UTF-8');
        Carbon::setLocale('es');
    
        // Usar el método findOrFail para manejar automáticamente la excepción si no se encuentra el registro
        $redb = Dbredb::with('rubros')->findOrFail($id); // Cargar rubros con pivote
        $empresa = Dbempresa::findOrFail($redb->dbempresa_id);
        $rubros = Dbrubro::all(); // Rubros disponibles
        $categorias = Dbcategoria::all(); // Categorías disponibles    
        $meses = [
            "January" => "Enero", "February" => "Febrero", "March" => "Marzo",
            "April" => "Abril", "May" => "Mayo", "June" => "Junio",
            "July" => "Julio", "August" => "Agosto", "September" => "Septiembre",
            "October" => "Octubre", "November" => "Noviembre", "December" => "Diciembre"
        ];
        
        $fechaActual = Carbon::now();
        $mes = $meses[$fechaActual->format('F')];
        $fechaFormateada = $fechaActual->format('d') . ' de ' . $mes . ' de ' . $fechaActual->format('Y');
    
        // Preparar la vista con los datos necesarios
        $response = response()->view('db.redb.certificado', compact('redb', 'empresa', 'fechaFormateada', 'rubros', 'categorias'));
        $response->header('Content-Language', 'es');
    
        return $response;
    }

    public function updateDt(Request $request, $id)
    {
    
        $redb = Dbreb::findOrFail($id);
        $redb->dbdt_id = $validatedData['id'];
        $redb->save();
    
        return redirect()->route('db_redb_index')->with('success', 'DT vinculado correctamente.');
    }   

}
