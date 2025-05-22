<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\User;
use App\Dbempresa;
use App\Dbrpadb;
use App\Dbredb;
use App\Dbhistorial;
use App\Dbrubro;
use App\Dbbaja;
use App\Dbcategoria;
use App\DbredbDbrubro;
use App\Dbtramite;
use App\Dbenvase;
use App\Nomenclador;
use App\Remitente;
use App\Factura;
use App\Dbexp;
use \PDF;
use Session;
 
class DbrpadbController extends Controller
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
        $empresaId = null;
        $redbs = collect([]); // Inicializar vacío para evitar errores
    
        if ($user->role_id == 15) {
            // Procesamiento para usuarios con role_id 15
            $empresa = $user->empresa()->first();
            
            if ($empresa) {
                $empresaId = $empresa->id;
                $redbs = Dbredb::with('dbtramites')
                    ->byEmpresa($empresaId)
                    ->whereHas('dbtramites', function ($query) {
                        $query->whereNotNull('dbexp_id');
                    })
                    ->latest('numero')
                    ->paginate(20);
            } else {
                session()->flash('error', 'No tienes empresas asociadas.');
            }
        } else {
            // Procesamiento para otros roles
            $numero = $request->get('numero');
            $establecimiento = $request->get('establecimiento');
            $redbs = Dbredb::with('dbtramites')
                ->whereHas('dbtramites', function ($query) {
                    $query->whereNotNull('dbexp_id');
                })        
                ->numero($numero)
                ->establecimiento($establecimiento)
                ->latest('numero')
                ->paginate(20);
        }
    
        // Consulta para `rpadbs` según el `role_id`
        $numero = $request->get('numero');
        $denominacion = $request->get('denominacion');
        $marca = $request->get('marca');
        $rpadbs = Dbrpadb::when($empresaId, function ($query) use ($empresaId) {
                return $query->where('dbempresa_id', $empresaId);
            })
            ->whereNotNull('numero')
            ->where('numero', '!=', '')
            ->when($numero, function ($query, $numero) {
                return $query->where('numero', $numero);
            })
            ->when($denominacion, function ($query, $denominacion) {
                return $query->where('denominacion', $denominacion);
            })
            ->when($marca, function ($query, $marca) {
                return $query->where('marca', $marca);
            })
            ->orderBy('numero', 'DESC')
            ->paginate(20);
    
        // Nomenclador y Factura
        $montoInscripcion = Nomenclador::where('descripcion', 'Registro Provincial de Alimento')->value('valor');
        $montoModificacion = Nomenclador::where('descripcion', 'Modificación RPADB')->value('valor');
        $montoReinscripcion = Nomenclador::where('descripcion', 'Reinscripción RPPA')->value('valor');
    
        $remitente = Remitente::where('user_id', $user->id)->first();
        $existeFacturaPendiente = $remitente && Factura::where('remitentes_id', $remitente->id)
            ->whereHas('nomencladors', function ($query) {
                $query->where('descripcion', 'Gestión Administrativa');
            })
            ->whereNull('fecha_pago')
            ->exists();
    
        // Verificar trámite de modificación pendiente en `rpadbs`
        $existeTramiteModificacionPendiente = false;
        foreach ($rpadbs as $rpadb) {
            if ($rpadb->dbtramites()
                ->where('tipo_tramite', 'LIKE', '%MODIFICACION%')
                ->where('estado', '<>', 'APROBADO')
                ->exists()) {
                $existeTramiteModificacionPendiente = true;
                break;
            }
        }
    
        return view('db.rpadb.index', compact(
            'rpadbs', 'redbs', 'existeFacturaPendiente',
            'montoInscripcion', 'montoModificacion', 'montoReinscripcion',
            'existeTramiteModificacionPendiente'
        ));
    }

    public function create_inscripcion(Request $request)
    {
        $user = Auth::user();
    
        // Verificar si el usuario está autenticado y tiene una empresa asociada
        if (!$user || !$user->empresa) {
            return redirect()->route('login')->withErrors('Debe estar autenticado para realizar esta acción.');
        }
    
        $empresaId = $user->empresa->id;
    
        // Obtener únicamente los REDB asociados a la empresa
        $redbs = DB::table('dbredbs')
        ->where('dbempresa_id', $empresaId)
        ->where(function ($query) {
            $query->where('dbbaja_id', 0)
                  ->orWhereNull('dbbaja_id');
        })
        ->select('id', 'numero', 'establecimiento', 'domicilio') // Ajusta los campos según tu modelo de datos
        ->get();
    
        return view('db.rpadb.create_inscripcion', compact('redbs'));
    }
    
    
    public function store_inscripcion(Request $request)
    {
        $user = Auth::user();

        if (!$user->empresa) {
            return redirect()->back()->withErrors('No hay una empresa asociada a este usuario.');
        }

        $empresaId = $user->empresa->id;

        $redbId = $request->input('redb_id');
        if (!$redbId) {
            return redirect()->back()->withErrors('Debe seleccionar un establecimiento.');
        }

        foreach ($request->input('productos', []) as $index => $productoData) {
            $rpadb = new Dbrpadb();
            $rpadb->denominacion = $request->input('denominacion');
            $rpadb->nombre_fantasia = $request->input('nombre_fantasia');
            $rpadb->marca = $request->input('marca');            
            $rpadb->fecha_reinscripcion = now()->addYears(5);
            $rpadb->user_id = $user->id;
            $rpadb->dbempresa_id = $empresaId;
            $rpadb->dbredb_id = $redbId;
            $rpadb->save();

            $tramite = new Dbtramite();
            $tramite->fecha_inicio = Carbon::now();
            $tramite->tipo_tramite = 'INSCRIPCION PRODUCTO';
            $tramite->estado = 'INICIADO';
            $tramite->dbempresa_id = $empresaId;
            $tramite->factura_id = $request->factura_id ?? null;
            $tramite->dbrpadb_id = $rpadb->id;
            $tramite->save();

            $carpeta = "empresa/{$empresaId}/rpadb/{$rpadb->id}";
            $subcarpetas = ['monografia', 'analisis', 'especificaciones', 'pago'];
            foreach ($subcarpetas as $subcarpeta) {
                Storage::makeDirectory("{$carpeta}/{$subcarpeta}");
            }

            $rpadb->ruta_monografia = json_encode($this->guardarMultiplesArchivos($request, "productos.{$index}.monografia", "{$carpeta}/monografia"));
            $rpadb->ruta_analisis = json_encode($this->guardarMultiplesArchivos($request, "productos.{$index}.analisis", "{$carpeta}/analisis"));
            $rpadb->ruta_especificaciones = json_encode($this->guardarMultiplesArchivos($request, "productos.{$index}.especificaciones", "{$carpeta}/especificaciones"));

            if ($request->hasFile("productos.{$index}.pago")) {
                $archivoPago = $request->file("productos.{$index}.pago");
                $nombrePago = time() . '-' . $archivoPago->getClientOriginalName();
                $rutaPago = $archivoPago->storeAs("{$carpeta}/pago", $nombrePago, 'local');
                $rpadb->ruta_pago = $rutaPago;
            }

            $rpadb->save();

            if (isset($productoData['envases']) && is_array($productoData['envases'])) {
                // Define la carpeta principal para envases
                $carpetaEnvases = "{$carpeta}/envases";
            
                // Crea las subcarpetas específicas
                Storage::makeDirectory("{$carpetaEnvases}/certificados");
                Storage::makeDirectory("{$carpetaEnvases}/rotulos");
            
                foreach ($productoData['envases'] as $envaseId => $envaseData) {
                    $envase = new Dbenvase();
                    $envase->fill($envaseData);
                    $envase->dbrpadb_id = $rpadb->id;
                    $envase->save();
            
                    // Guardar archivo de certificado
                    if ($request->hasFile("productos.{$index}.envases.{$envaseId}.certificado_envase")) {
                        $this->subirArchivoEnvase(
                            $request->file("productos.{$index}.envases.{$envaseId}.certificado_envase"),
                            $envase,
                            'ruta_cert_envase',
                            "{$carpetaEnvases}/certificados"
                        );
                    }
            
                    // Guardar archivo de rótulo
                    if ($request->hasFile("productos.{$index}.envases.{$envaseId}.rotulo_envase")) {
                        $this->subirArchivoEnvase(
                            $request->file("productos.{$index}.envases.{$envaseId}.rotulo_envase"),
                            $envase,
                            'ruta_rotulo',
                            "{$carpetaEnvases}/rotulos"
                        );
                    }
                }
            }            

            $dbhistorial = new Dbhistorial();
            $dbhistorial->fecha = Carbon::now();
            $dbhistorial->area = 'PRODUCTOR';
            $dbhistorial->motivo = 'INSCRIPCION PRODUCTO';
            $dbhistorial->observaciones = 'Se envía información y documentación para la inscripción del producto.';
            $dbhistorial->user_id = $user->id;
            $dbhistorial->dbempresa_id = $empresaId;
            $dbhistorial->dbtramite_id = $tramite->id;
            $dbhistorial->save();
        }

        return redirect('/tramites/index')->with('notification', 'El producto fue ingresado correctamente.');
    }

    /**
     * Guardar múltiples archivos y retornar un array de rutas.
     */
    private function guardarMultiplesArchivos(Request $request, $key, $carpeta, $disco = 'local')
    {
        $rutas = [];

        // Verificar si existen archivos en la clave
        if ($request->has($key) && is_array($request->file($key))) {
            foreach ($request->file($key) as $archivo) {
                if ($archivo->isValid()) {
                    $nombre = time() . '-' . $archivo->getClientOriginalName();
                    $ruta = $archivo->storeAs($carpeta, $nombre, 'local');
                    $rutas[] = $ruta;
                } else {
                    Log::error("Archivo inválido: {$archivo->getClientOriginalName()}");
                }
            }
        } else {
            Log::error("No se encontraron archivos para la clave: {$key}");
        }

        return $rutas;
    }
     
    public function show($id)
    {
        $rpadb = Dbrpadb::with('dbempresa', 'dbredb.localidad', 'dbbaja')->findOrFail($id);
    
        return view('db.rpadb.show', compact('rpadb'));
    }
    

    public function edit($id)
    {
        // Cargar el registro de Dbrpadb según el ID
        $rpadb = Dbrpadb::findOrFail($id);

        // Retornar la vista de edición con los datos del producto
        return view('rpadb.edit', compact('rpadb'));
    }

    public function edit_inscripcion(Request $request, $id)
    {
        \Log::info("Inicio del método edit_inscripcion con ID: {$id}");
    
        $user = Auth::user();
        if (!$user) {
            \Log::warning("Usuario no autenticado. Redirigiendo a login.");
            return redirect()->route('login')->withErrors('Debe estar autenticado para realizar esta acción.');
        }
    
        \Log::info("Usuario autenticado: ID {$user->id}, Email: {$user->email}");
    
        // Obtener el RPADB a editar
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        \Log::info("RPADB encontrado: ID {$rpadb->id}, Denominación: {$rpadb->denominacion}");
    
        // Verificar el rol del usuario
        if ($user->role_id === 15) {
            // Si el usuario tiene rol 15, obtener la empresa asociada
            $empresa = $user->empresa;
            if (!$empresa) {
                \Log::warning("Usuario ID {$user->id} no tiene una empresa asociada.");
                session()->flash('error', 'No tienes empresas asociadas.');
                return redirect()->back();
            }
            $empresaId = $empresa->id;
            \Log::info("Empresa asociada al usuario: Empresa ID {$empresaId}");
        } else {
            $empresaId = null;
            \Log::info("Usuario ID {$user->id} no requiere empresa asociada (Rol: {$user->role_id}).");
        }
    
        // Obtener rubros y categorías asociados a la empresa, si aplica
        $pivotcat = DB::table('dbredb_dbrubro')
            ->join('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
            ->join('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
            ->join('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('dbredbs.dbempresa_id', $empresaId);
            })
            ->where(function ($query) {
                $query->whereNull('dbredbs.dbbaja_id')
                      ->orWhere('dbredbs.dbbaja_id', 0);
            })
            ->select(
                'dbredb_dbrubro.*',
                'dbcategorias.categoria as categoria_nombre',
                'dbrubros.rubro as rubro_nombre',
                'dbredbs.numero as redb_numero'
            )
            ->get();
    
        \Log::info("Rubros y categorías obtenidos: Total " . $pivotcat->count());
    
        // Obtener trámite relacionado con el RPADB
        $tramiteId = $request->input('tramite_id');
        \Log::info("Trámite ID proporcionado: " . ($tramiteId ?? "Ninguno"));
    
        $tramite = $tramiteId 
            ? $rpadb->dbtramites()->where('id', $tramiteId)->first()
            : $rpadb->dbtramites()->latest()->first();
    
        if (!$tramite && $tramiteId) {
            \Log::warning("Trámite con ID {$tramiteId} no encontrado para RPADB ID {$id}.");
            return redirect()->back()->withErrors('El trámite seleccionado no existe o no está asociado a este RPADB.');
        }
    
        if ($tramite) {
            \Log::info("Trámite asociado encontrado: ID {$tramite->id}, Tipo: {$tramite->tipo_tramite}");
        }
    
        $currentRubroId = $rpadb->dbredb_dbrubro_id ?? null;
        \Log::info("Rubro actual del RPADB: " . ($currentRubroId ?? "Ninguno"));
    
        $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
        if ($historial) {
            \Log::info("Historial encontrado para RPADB ID {$id}: ID {$historial->id}, Estado: {$historial->estado}");
        } else {
            \Log::info("No se encontró historial para RPADB ID {$id}.");
        }
    
        $ultimoHistorial = $tramite ? $tramite->historial()->latest()->first() : null;
        if ($ultimoHistorial) {
            \Log::info("Último historial del trámite encontrado: ID {$ultimoHistorial->id}");
        }
    
        // REDBs válidos (sin baja) según empresa
        $redbs = DB::table('dbredbs')
            ->when($empresaId, function ($query) use ($empresaId) {
                $query->where('dbempresa_id', $empresaId);
            })
            ->where(function ($query) {
                $query->whereNull('dbbaja_id')->orWhere('dbbaja_id', 0);
            })
            ->orderBy('establecimiento')
            ->get();
    
        // DETERMINAR SI EL USUARIO PUEDE EDITAR LOS CAMPOS
        $modoEdicion = ($user->role_id === 15 && $tramite && $tramite->estado === 'INICIADO') || 
                       ($user->role_id === 15 && $tramite && $tramite->estado === 'DEVUELTO');
    
        \Log::info("modoEdicion determinado como: " . ($modoEdicion ? 'true' : 'false'));
        
        $historiales = Dbhistorial::where('dbtramite_id', $tramite->id)
        ->orderBy('fecha', 'asc')
        ->with('user')
        ->get();
        $rubros = $rpadb->dbredb->rubros ?? collect();
        $categorias = Dbcategoria::all()->keyBy('id');

        $monografia_preview_html = $this->generatePreviewHtml($rpadb->ruta_monografia, '/rpadb/' . $rpadb->id . '/monografia/');
        $pago_preview_html = $this->generatePreviewHtml($rpadb->ruta_pago, '/rpadb/' . $rpadb->id . '/pago/');
        $analisis_preview_html = $this->generatePreviewHtml($rpadb->ruta_analisis, '/rpadb/' . $rpadb->id . '/analisis/');
        $especificaciones_preview_html = $this->generatePreviewHtml($rpadb->ruta_especificaciones, '/rpadb/' . $rpadb->id . '/especificaciones/');

        return view('db.rpadb.edit_inscripcion', compact(
            'rpadb', 'pivotcat', 'tramite', 'currentRubroId',
            'historial', 'ultimoHistorial', 'redbs', 'modoEdicion', 'historiales', 'rubros', 'categorias',
            'monografia_preview_html',
            'pago_preview_html',
            'analisis_preview_html',
            'especificaciones_preview_html'
        ));
    }

    private function generatePreviewHtml($ruta, $baseUrl)
    {
        if (!$ruta) {
            return null;
        }

        $html = '';
        $rutas = is_array(json_decode($ruta, true)) ? json_decode($ruta, true) : [$ruta];

        foreach ($rutas as $ruta) {
            $filename = basename($ruta);
            $url = url($baseUrl . $filename);
            $html .= "<embed src='{$url}' type='application/pdf' width='100%' height='150px'><br>";
        }

        return $html;
    }

    public function update_inscripcion(Request $request, $rpadbId, $tramiteId)
    {
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($rpadbId);
        $tramite = Dbtramite::findOrFail($tramiteId);
        $zona = $rpadb->dbredb->localidad->zona ?? null;
        $empresaId = $rpadb->dbempresa_id;
        $submitType = $request->input('submitType');
    
        \Log::info('delete_monografia:', $request->input('productos.0.delete_monografia', []));
    
        // ============================
        // ACTUALIZACIÓN DEL PRODUCTO
        // ============================

        if ($user->role_id === 15) { // PRODUCTOR
            $rpadb->denominacion = $request->input('denominacion');
            $rpadb->nombre_fantasia = $request->input('productos.0.nombre_fantasia');
            $rpadb->marca = $request->input('marca');
            $rpadb->dbredb_id = $request->input('productos.0.selected_item_id');
            $rpadb->save();
    
            $this->actualizarArchivos($request, $rpadb);
            $this->actualizarEnvases($request, $rpadb);
        }
        if ($user->role_id !== 15) {
            $rpadb->dbredb_dbrubro_id = $request->input('dbredb_dbrubro_id');
            $rpadb->articulo_caa = $request->input('articulo_caa');
            \Log::info('Rubro enviado', [
                'valor' => $request->input('dbredb_dbrubro_id')
            ]);
            $rpadb->save();
        }
        // ============================
        // ACCIÓN SEGÚN SUBMIT TYPE
        // ============================
    
        $area = null; // Aseguramos inicialización
        $motivo = null;
    
        if ($submitType === 'reenvio_empresa') {
            $tramite->estado = 'REENVIADO POR EMPRESA';
            $area = 'PRODUCTOR';
            $motivo = 'REENVÍO DE INFORMACIÓN';
    
        } elseif ($submitType === 'evaluado') {
            if (in_array($user->role_id, [16, 17, 18]) && in_array($zona, ['appm', 'ape', 'apcr'])) {
                $tramite->estado = 'EVALUADO POR AREA PROGRAMATICA';
                $area = 'AREA PROGRAMATICA';
                $motivo = 'EVALUADO POR ÁREA';
            } else {
                return back()->with('danger', 'No tiene permisos para realizar esta acción.');
            }
    
        } elseif ($submitType === 'devolver') {
            if ($user->role_id === 1) { // ADMIN devuelve siempre a NC
                $tramite->estado = 'DEVUELTO A NC';
                $area = 'ADMIN';
                $motivo = 'DEVUELTO A NIVEL CENTRAL';
            } elseif ($user->role_id === 9) { // Nivel central
                if ($zona === 'nc') {
                    $tramite->estado = 'DEVUELTO';
                    $area = 'NIVEL CENTRAL';
                    $motivo = 'DEVUELTO A PRODUCTOR';
                } else {
                    $tramite->estado = 'DEVUELTO A AREA';
                    $area = 'NIVEL CENTRAL';
                    $motivo = 'DEVUELTO A ÁREA';
                }
            } elseif (in_array($user->role_id, [16, 17, 18])) { // Área programática
                $tramite->estado = 'DEVUELTO';
                $area = 'AREA PROGRAMATICA';
                $motivo = 'DEVUELTO A PRODUCTOR';
            } else {
                return back()->with('danger', 'No tiene permisos para devolver este trámite.');
            }
        } elseif ($submitType === 'aprobar') {
            if ($user->role_id === 9 && ($zona === 'nc' || $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA')) {
                $tramite->estado = 'APROBADO';
                $area = 'NIVEL CENTRAL';
                $motivo = 'TRÁMITE APROBADO';
            } else {
                return back()->with('danger', 'No tiene permisos para aprobar este trámite.');
            }
    
        } elseif ($submitType === 'inscribir' && $user->role_id === 1) {
            $maxNumero = Dbrpadb::max('numero');
            $rpadb->numero = ($maxNumero !== null && $maxNumero > 0) ? $maxNumero + 1 : 1;
            $rpadb->fecha_inscripcion = Carbon::now();
            $rpadb->fecha_reinscripcion = Carbon::now()->addYears(5)->toDateString();
            $rpadb->finalizado = "1";
            if ($user->role_id === 1 && $tramite->estado === 'APROBADO') {
                // Generar número secuencial de expediente
                $nextId = Dbexp::max('id') + 1;
                $exp = new Dbexp();
                $exp->numero = 'EXP-' . str_pad($nextId, 5, '0', STR_PAD_LEFT); // Ej: EXP-01421
                $exp->fecha = now();
                $exp->save();
            
                // Asociar expediente creado al trámite
                $tramite->dbexp_id = $exp->id;
                $tramite->save();
            }                    
            $rpadb->save();
    
            $tramite->estado = 'INSCRIPTO';
            $area = 'ADMINISTRADOR';
            $motivo = 'INSCRIPCIÓN COMPLETA';
    
        } else {
            return redirect()->back()->withErrors('Acción no válida.');
        }
    
        // ============================
        // ACTUALIZAR TRÁMITE Y HISTORIAL
        // ============================
        $tramite->observaciones = $request->input('observaciones');
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = $area ?? 'SIN ÁREA DEFINIDA';
        $historial->motivo = $motivo ?? 'SIN MOTIVO DEFINIDO';
        $historial->observaciones = $tramite->observaciones;
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $empresaId;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'El trámite fue actualizado correctamente.');
    } 
       
    private function actualizarArchivos(Request $request, $rpadb)
    {
        $carpeta = "empresa/{$rpadb->dbempresa_id}/rpadb/{$rpadb->id}";
    
        $tiposArchivos = [
            'monografia' => 'productos.0.monografia',
            'analisis' => 'productos.0.analisis',
            'especificaciones' => 'productos.0.especificaciones'
        ];
    
        foreach ($tiposArchivos as $tipo => $campo) {
            // === Eliminar solo rutas seleccionadas de la base de datos ===
            if ($request->has("productos.0.delete_$tipo")) {
                $rutasAEliminar = $request->input("productos.0.delete_$tipo");
                $archivosActuales = json_decode($rpadb->{"ruta_$tipo"}, true) ?? [];
    
                // Filtramos los que NO están marcados para eliminar
                $nuevasRutas = array_values(array_diff($archivosActuales, $rutasAEliminar));
                $rpadb->{"ruta_$tipo"} = json_encode($nuevasRutas);
                $rpadb->save();
    
                Log::info("🗑️ Rutas eliminadas de {$tipo} (solo en BD):", $rutasAEliminar);
            }
    
            // === Agregar archivos nuevos (sumar a los existentes) ===
            if ($request->hasFile($campo)) {
                $archivosNuevos = $this->guardarMultiplesArchivos($request, $campo, "$carpeta/$tipo", 'local');
    
                if (!empty($archivosNuevos)) {
                    $archivosActuales = json_decode($rpadb->{"ruta_$tipo"}, true) ?? [];
                    $todos = array_merge($archivosActuales, $archivosNuevos);
    
                    $rpadb->{"ruta_$tipo"} = json_encode($todos);
                    $rpadb->save();
    
                    Log::info("📥 Nuevos archivos agregados a {$tipo}:", $archivosNuevos);
                }
            }
        }
    
        // Comprobante de pago sigue igual
        if ($request->hasFile('productos.0.pago')) {
            $this->actualizarPago($request, $rpadb, $carpeta);
        }
    }

    private function eliminarArchivos($rpadb, $tipo, $rutasAEliminar)
    {
        $archivosActuales = json_decode($rpadb->{"ruta_$tipo"}, true) ?? [];
        $nuevosArchivos = array_diff($archivosActuales, $rutasAEliminar);

        // 🚮 Eliminar los archivos del almacenamiento
        foreach ($rutasAEliminar as $ruta) {
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
        }

        // 🔄 Actualizar la base de datos
        $rpadb->{"ruta_$tipo"} = !empty($nuevosArchivos) ? json_encode(array_values($nuevosArchivos)) : null;
        $rpadb->save();
    }
    
    private function actualizarEnvases(Request $request, $rpadb)
    {
        Log::info("🔄 Procesando envases para RPADB ID: {$rpadb->id}");
    
        $envasesActuales = $rpadb->envases->keyBy('id');
        $envasesRequest = $request->input('envases', []);
        $envasesFiles = $request->file('envases', []);
    
        Log::debug('🧾 Datos de envasesRequest:', $envasesRequest);
        Log::debug('📎 Archivos recibidos envasesFiles:', $envasesFiles);
    
        // Define las carpetas específicas para certificados y rótulos
        $carpetaBase = "empresa/{$rpadb->dbempresa_id}/rpadb/{$rpadb->id}/envases";
        $carpetaCertificados = "{$carpetaBase}/certificados";
        $carpetaRotulos = "{$carpetaBase}/rotulos";
    
        // Asegúrate que las carpetas existan
        Storage::makeDirectory($carpetaCertificados);
        Storage::makeDirectory($carpetaRotulos);
    
        foreach ($envasesRequest as $envaseId => $envaseData) {
            Log::info("➡️ Procesando envase ID: $envaseId");
    
            if (is_numeric($envaseId) && $envasesActuales->has($envaseId)) {
                $envase = $envasesActuales->get($envaseId);
                $envase->update($envaseData);
    
                if (isset($envasesFiles[$envaseId]['certificado_envase'])) {
                    Log::info("📤 Subiendo certificado para envase ID: $envaseId");
                    $this->subirArchivoEnvase($envasesFiles[$envaseId]['certificado_envase'], $envase, 'ruta_cert_envase', $carpetaCertificados);
                }
    
                if (isset($envasesFiles[$envaseId]['rotulo_envase'])) {
                    Log::info("📤 Subiendo rótulo para envase ID: $envaseId");
                    $this->subirArchivoEnvase($envasesFiles[$envaseId]['rotulo_envase'], $envase, 'ruta_rotulo', $carpetaRotulos);
                } else {
                    Log::warning("⚠️ NO llegó archivo rotulo_envase para envase ID: $envaseId");
                }
            }
    
            if (str_starts_with($envaseId, 'new')) {
                $nuevo = new Dbenvase($envaseData);
                $nuevo->dbrpadb_id = $rpadb->id;
                $nuevo->save();
                Log::info("✅ Nuevo envase creado ID: {$nuevo->id}");
    
                if (isset($envasesFiles[$envaseId]['certificado_envase'])) {
                    Log::info("📤 Subiendo certificado nuevo envase ID: {$nuevo->id}");
                    $this->subirArchivoEnvase($envasesFiles[$envaseId]['certificado_envase'], $nuevo, 'ruta_cert_envase', $carpetaCertificados);
                }
    
                if (isset($envasesFiles[$envaseId]['rotulo_envase'])) {
                    Log::info("📤 Subiendo rótulo nuevo envase ID: {$nuevo->id}");
                    $this->subirArchivoEnvase($envasesFiles[$envaseId]['rotulo_envase'], $nuevo, 'ruta_rotulo', $carpetaRotulos);
                } else {
                    Log::warning("⚠️ NO llegó archivo rotulo_envase para nuevo envase ID: $envaseId");
                }
            }
        }
    
        $envasesAEliminar = $envasesActuales->keys()->diff(collect($envasesRequest)->keys());
        Log::info("🗑️ Envases a eliminar: ", $envasesAEliminar->toArray());
        Dbenvase::destroy($envasesAEliminar);
    }
    
    private function subirArchivoEnvase($archivo, $envase, $campoRuta, $carpeta)
    {
        if ($envase->{$campoRuta}) {
            Storage::delete($envase->{$campoRuta});
        }

        $nombreArchivo = time() . '-' . $archivo->getClientOriginalName();
        $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'local');
        $envase->{$campoRuta} = $ruta;
        $envase->save();

        \Log::info("📁 Archivo {$campoRuta} actualizado para envase ID {$envase->id}: {$ruta}");
    }
    
    private function agregarArchivos($rpadb, $tipo, $nuevosArchivos)
    {
        $archivosActuales = json_decode($rpadb->{"ruta_$tipo"}, true) ?? [];
        $todosArchivos = array_merge($archivosActuales, $nuevosArchivos);
    
        // 🔄 **Actualizar la base de datos**
        $rpadb->{"ruta_$tipo"} = json_encode($todosArchivos);
        $rpadb->save();
    }
    
    private function actualizarPago($request, $rpadb, $carpeta)
    {
        // 🚮 **Eliminar pago anterior si existe**
        if ($rpadb->ruta_pago) {
            Storage::delete($rpadb->ruta_pago);
        }
    
        // 📂 **Subir nuevo archivo**
        $archivo = $request->file('productos.0.pago');
        $nombreArchivo = time() . '-' . $archivo->getClientOriginalName();
        $ruta = $archivo->storeAs("$carpeta/pago", $nombreArchivo, 'local');
    
        // 🔄 **Actualizar la base de datos**
        $rpadb->ruta_pago = $ruta;
        $rpadb->save();
    }
    
    public function certificado($id)
    {
        $rpadb = Dbrpadb::with([
            'dbempresa.localidad.provincia',
            'dbredb',
            'tramites.dbexp' // <-- Asegurate de tener esta relación definida
        ])->findOrFail($id);
    
        $dbempresa = $rpadb->dbempresa;
        $dbredb = $rpadb->dbredb;
    
        // Buscar el trámite de tipo INSCRIPCION
        $tramite = $rpadb->tramites->where('finalizado', 1)->first();
    
        return view('db.rpadb.certificado')->with(compact('rpadb', 'dbempresa', 'dbredb', 'tramite'));
    }    

    public function getRubros($id)
    {
        $rubros = DbredbDbrubro::where('dbrubro_id', $id)->get();
        return response()->json($categorias);
    }

    private function verArchivoDesdeJson($rpadb, $campoJson, $filename)
    {
        if (!preg_match('/^[\w\s\-\.]+\.(pdf|PDF)$/', $filename)) {
            abort(400, 'Nombre de archivo inválido.');
        }

        $rutas = json_decode($rpadb->{$campoJson}, true);
        if (!is_array($rutas)) {
            abort(404, 'No se encontraron archivos.');
        }

        $rutaCompleta = collect($rutas)->first(function ($ruta) use ($filename) {
            return basename($ruta) === $filename;
        });

        if (!$rutaCompleta || !file_exists(storage_path("app/{$rutaCompleta}"))) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->file(storage_path("app/{$rutaCompleta}"), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function verMonografia($id, $filename)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        return $this->verArchivoDesdeJson($rpadb, 'ruta_monografia', $filename);
    }
    
    public function verRotulo($id, $filename)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        return $this->verArchivoDesdeJson($rpadb, 'ruta_rotulo', $filename);
    }
    
    public function verAnalisis($id, $filename)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        return $this->verArchivoDesdeJson($rpadb, 'ruta_analisis', $filename);
    }
    
    public function verEspecificaciones($id, $filename)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        return $this->verArchivoDesdeJson($rpadb, 'ruta_especificaciones', $filename);
    }
    
    
    public function verPago($id, $filename)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutas = is_array(json_decode($rpadb->ruta_pago, true)) 
            ? json_decode($rpadb->ruta_pago, true) 
            : [$rpadb->ruta_pago];
    
        $ruta = collect($rutas)->first(function ($ruta) use ($filename) {
            return basename($ruta) === $filename;
        });
    
        if (!$ruta || !file_exists(storage_path("app/{$ruta}"))) {
            abort(404, 'Archivo no encontrado.');
        }
    
        return response()->file(storage_path("app/{$ruta}"), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
    
    
    public function verCERTENVASE($id)
    {
        // Buscar el envase por su propio ID
        $envase = Dbenvase::findOrFail($id);
    
        // Obtener la ruta del archivo de certificado
        $rutaArchivo = storage_path('app/' . $envase->ruta_cert_envase);
    
        // Verificar si el archivo existe
        if (!file_exists($rutaArchivo)) {
            abort(404, 'El certificado del envase no se encontró.');
        }
    
        // Definir los encabezados para la respuesta
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        // Devolver el archivo como una respuesta
        return response()->file($rutaArchivo, $headers);
    }

    public function verRotuloEnvase($id)
    {
        // Buscar el envase por su propio ID
        $envase = Dbenvase::findOrFail($id);
    
        // Obtener la ruta del archivo de certificado
        $rutaArchivo = storage_path('app/' . $envase->ruta_rotulo);
    
        // Verificar si el archivo existe
        if (!file_exists($rutaArchivo)) {
            abort(404, 'El certificado del envase no se encontró.');
        }
    
        // Definir los encabezados para la respuesta
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        // Devolver el archivo como una respuesta
        return response()->file($rutaArchivo, $headers);
    }

    public function create_modificacion(Request $request)
    {
        $user = Auth::user();
    
        if ($user->role_id !== 15) {
            abort(403, 'No tiene permisos para esta acción.');
        }
    
        $rpadbId = $request->input('rpadb_id');
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($rpadbId);
    
        $empresa = $user->empresa;
        if (!$empresa) {
            return redirect()->back()->withErrors('No tienes una empresa asociada.');
        }
    
        $empresaId = $empresa->id;
    
        // Obtener establecimientos válidos para esa empresa
        $redbs = DB::table('dbredbs')
            ->where('dbempresa_id', $empresaId)
            ->where(function ($query) {
                $query->whereNull('dbbaja_id')
                    ->orWhere('dbbaja_id', 0);
            })
            ->orderBy('establecimiento')
            ->get();
    
        // Obtener rubros para el establecimiento actual del producto
        $rubros = $rpadb->dbredb->rubros ?? collect();
        $categorias = Dbcategoria::all()->keyBy('id');
    
        return view('db.rpadb.create_modificacion', compact(
            'rpadb', 'redbs', 'rubros', 'categorias'
        ));
    }
    
       
    public function store_modificacion(Request $request, $id)
    {
        $user = Auth::user();
    
        if (!$user->empresa) {
            return redirect()->back()->withErrors('No hay una empresa asociada a este usuario.');
        }
    
        $empresaId = $user->empresa->id;
    
        $rpadb = Dbrpadb::findOrFail($id);
    
        // Crear nuevo trámite de modificación
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'MODIFICACION PRODUCTO';
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $empresaId;
        $tramite->factura_id = $request->factura_id ?? null;
        $tramite->dbrpadb_id = $rpadb->id;
        $tramite->save();
    
        // Ruta de archivos
        $carpeta = "empresa/{$empresaId}/rpadb/{$rpadb->id}";
        $subcarpetas = ['monografia', 'analisis', 'especificaciones', 'pago'];
        foreach ($subcarpetas as $subcarpeta) {
            Storage::makeDirectory("{$carpeta}/{$subcarpeta}");
        }
    
        // Guardar archivos nuevos
        $rpadb->ruta_monografia = json_encode($this->guardarMultiplesArchivos($request, "productos.0.monografia", "{$carpeta}/monografia"));
        $rpadb->ruta_analisis = json_encode($this->guardarMultiplesArchivos($request, "productos.0.analisis", "{$carpeta}/analisis"));
        $rpadb->ruta_especificaciones = json_encode($this->guardarMultiplesArchivos($request, "productos.0.especificaciones", "{$carpeta}/especificaciones"));
    
        if ($request->hasFile("productos.0.pago")) {
            $archivoPago = $request->file("productos.0.pago");
            $nombrePago = time() . '-' . $archivoPago->getClientOriginalName();
            $rutaPago = $archivoPago->storeAs("{$carpeta}/pago", $nombrePago, 'local');
            $rpadb->ruta_pago = $rutaPago;
        }
    
        $rpadb->save();
    
        // Actualizar envases
        if (isset($request->productos[0]['envases']) && is_array($request->productos[0]['envases'])) {
            $carpetaEnvases = "{$carpeta}/envases";
            Storage::makeDirectory("{$carpetaEnvases}/certificados");
            Storage::makeDirectory("{$carpetaEnvases}/rotulos");
    
            foreach ($request->productos[0]['envases'] as $envaseId => $envaseData) {
                $envase = new Dbenvase();
                $envase->fill($envaseData);
                $envase->dbrpadb_id = $rpadb->id;
                $envase->save();
    
                if ($request->hasFile("productos.0.envases.{$envaseId}.certificado_envase")) {
                    $this->subirArchivoEnvase(
                        $request->file("productos.0.envases.{$envaseId}.certificado_envase"),
                        $envase,
                        'ruta_cert_envase',
                        "{$carpetaEnvases}/certificados"
                    );
                }
    
                if ($request->hasFile("productos.0.envases.{$envaseId}.rotulo_envase")) {
                    $this->subirArchivoEnvase(
                        $request->file("productos.0.envases.{$envaseId}.rotulo_envase"),
                        $envase,
                        'ruta_rotulo',
                        "{$carpetaEnvases}/rotulos"
                    );
                }
            }
        }
    
        // Registrar historial
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha = Carbon::now();
        $dbhistorial->area = 'PRODUCTOR';
        $dbhistorial->motivo = 'MODIFICACION PRODUCTO';
        $dbhistorial->observaciones = 'Se solicita la modificación del producto.';
        $dbhistorial->user_id = $user->id;
        $dbhistorial->dbempresa_id = $empresaId;
        $dbhistorial->dbtramite_id = $tramite->id;
        $dbhistorial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'La modificación fue registrada correctamente.');
    }

    public function edit_modificacion(Request $request, $id)
    {
        \Log::info("Inicio del método edit_modificacion con ID: {$id}");
    
        $user = Auth::user();
        if (!$user) {
            \Log::warning("Usuario no autenticado. Redirigiendo a login.");
            return redirect()->route('login')->withErrors('Debe estar autenticado para realizar esta acción.');
        }
    
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        $empresaId = $user->role_id === 15 ? optional($user->empresa)->id : null;
    
        $pivotcat = DB::table('dbredb_dbrubro')
            ->join('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
            ->join('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
            ->join('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
            ->when($empresaId, fn($q) => $q->where('dbredbs.dbempresa_id', $empresaId))
            ->where(function ($query) {
                $query->whereNull('dbredbs.dbbaja_id')->orWhere('dbredbs.dbbaja_id', 0);
            })
            ->select(
                'dbredb_dbrubro.*',
                'dbcategorias.categoria as categoria_nombre',
                'dbrubros.rubro as rubro_nombre',
                'dbredbs.numero as redb_numero'
            )
            ->get();
    
        $tramiteId = $request->input('tramite_id');
        $tramite = $tramiteId
            ? $rpadb->dbtramites()->where('id', $tramiteId)->first()
            : $rpadb->dbtramites()
                ->where('tipo_tramite', 'MODIFICACION PRODUCTO')
                ->where('estado', '!=', 'MODIFICADO')
                ->latest()
                ->first();
    
        if ($tramiteId && !$tramite) {
            return redirect()->back()->withErrors('El trámite seleccionado no existe o no está asociado a este RPADB.');
        }
    
        $tramiteExistente = Dbtramite::where('tipo_tramite', 'MODIFICACION PRODUCTO')
            ->where('estado', '!=', 'MODIFICADO')
            ->where('dbrpadb_id', $rpadb->id)
            ->first();
    
        $currentRubroId = $rpadb->dbredb_dbrubro_id ?? null;
        $ultimoHistorial = $tramite ? $tramite->historial()->latest()->first() : null;
    
        $redbs = DB::table('dbredbs')
            ->when($empresaId, fn($q) => $q->where('dbempresa_id', $empresaId))
            ->where(function ($q) {
                $q->whereNull('dbbaja_id')->orWhere('dbbaja_id', 0);
            })
            ->orderBy('establecimiento')
            ->get();
    
        $modoEdicion = ($user->role_id === 15 && $tramite && in_array($tramite->estado, ['INICIADO', 'DEVUELTO']));
    
        // SOLO historial del trámite actual (si existe)
        $historiales = $tramite
            ? Dbhistorial::where('dbtramite_id', $tramite->id)->orderBy('fecha', 'asc')->with('user')->get()
            : collect();
    
        $rubros = $rpadb->dbredb->rubros ?? collect();
        $categorias = Dbcategoria::all()->keyBy('id');
    
        return view('db.rpadb.edit_modificacion', compact(
            'rpadb', 'pivotcat', 'tramite', 'currentRubroId',
            'ultimoHistorial', 'redbs', 'modoEdicion', 'historiales',
            'rubros', 'categorias', 'tramiteExistente'
        ));
    }
    
    public function update_modificacion(Request $request, $id)
    {
        \Log::info("===> Entró al método update_modificacion con RPADB ID: {$id}");
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        $tramiteId = $request->input('tramite_id');
        $tramite = $tramiteId ? Dbtramite::find($tramiteId) : null;
        if (!$tramite) {
            $tramite = new Dbtramite();
            $tramite->tipo_tramite = 'MODIFICACION PRODUCTO';
            $tramite->estado = 'INICIADO';
            $tramite->dbempresa_id = $rpadb->dbempresa_id;
            $tramite->dbrpadb_id = $rpadb->id;
            $tramite->save();
        }
        $zona = $rpadb->dbredb->localidad->zona ?? null;
        $empresaId = $rpadb->dbempresa_id;
        $submitType = $request->input('submitType');
        $mostrarCampoObservaciones = false;

        if ($tramite) {
            if ($user->role_id === 15 && in_array($tramite->estado, ['INICIADO', 'DEVUELTO'])) {
                $mostrarCampoObservaciones = true;
            }
        
            if (in_array($user->role_id, [16, 17, 18]) && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO A AREA']) && in_array($zona, ['appm', 'ape', 'apcr'])) {
                $mostrarCampoObservaciones = true;
            }
        
            if ($user->role_id === 9 && (
                ($tramite->estado === 'INICIADO' && $zona === 'nc') ||
                $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA' ||
                ($tramite->estado === 'REENVIADO POR EMPRESA' && $zona === 'nc') ||
                $tramite->estado === 'DEVUELTO A NC'
            )) {
                $mostrarCampoObservaciones = true;
            }
        
            if ($user->role_id === 1 && $tramite->estado === 'APROBADO') {
                $mostrarCampoObservaciones = true;
            }
        }
        if ($mostrarCampoObservaciones) {
            $request->validate([
                'observaciones' => 'required|string|max:1000',
            ]);
        }
        \Log::info('delete_monografia:', $request->input('productos.0.delete_monografia', []));
    
        // ============================
        // ACTUALIZACIÓN DEL PRODUCTO
        // ============================
        if ($user->role_id === 15) { // PRODUCTOR
            $rpadb->denominacion = $request->input('denominacion');
            $rpadb->nombre_fantasia = $request->input('productos.0.nombre_fantasia');
            $rpadb->marca = $request->input('marca');
            $rpadb->dbredb_id = $request->input('productos.0.selected_item_id');
            $rpadb->save();
    
            $this->actualizarArchivos($request, $rpadb);
            $this->actualizarEnvases($request, $rpadb);
        }
    
        if ($user->role_id !== 15) {
            $rpadb->dbredb_dbrubro_id = $request->input('dbredb_dbrubro_id');
            $rpadb->articulo_caa = $request->input('articulo_caa');
            \Log::info('Rubro enviado', [
                'valor' => $request->input('dbredb_dbrubro_id')
            ]);
            $rpadb->save();
        }
    
        // ============================
        // ACCIÓN SEGÚN SUBMIT TYPE
        // ============================
        $area = null;
        $motivo = null;
    
        if ($submitType === 'reenvio_empresa') {
            $tramite->estado = 'REENVIADO POR EMPRESA';
            $area = 'PRODUCTOR';
            $motivo = 'REENVÍO DE INFORMACIÓN';
    
        } elseif ($submitType === 'evaluado') {
            if (in_array($user->role_id, [16, 17, 18]) && in_array($zona, ['appm', 'ape', 'apcr'])) {
                $tramite->estado = 'EVALUADO POR AREA PROGRAMATICA';
                $area = 'AREA PROGRAMATICA';
                $motivo = 'EVALUADO POR ÁREA';
            } else {
                return back()->with('danger', 'No tiene permisos para realizar esta acción.');
            }
    
        } elseif ($submitType === 'devolver') {
            if ($user->role_id === 1) {
                $tramite->estado = 'DEVUELTO A NC';
                $area = 'ADMIN';
                $motivo = 'DEVUELTO A NIVEL CENTRAL';
            } elseif ($user->role_id === 9) {
                if ($zona === 'nc') {
                    $tramite->estado = 'DEVUELTO';
                    $area = 'NIVEL CENTRAL';
                    $motivo = 'DEVUELTO A PRODUCTOR';
                } else {
                    $tramite->estado = 'DEVUELTO A AREA';
                    $area = 'NIVEL CENTRAL';
                    $motivo = 'DEVUELTO A ÁREA';
                }
            } elseif (in_array($user->role_id, [16, 17, 18])) {
                $tramite->estado = 'DEVUELTO';
                $area = 'AREA PROGRAMATICA';
                $motivo = 'DEVUELTO A PRODUCTOR';
            } else {
                return back()->with('danger', 'No tiene permisos para devolver este trámite.');
            }
    
        } elseif ($submitType === 'aprobar') {
            if ($user->role_id === 9 && ($zona === 'nc' || $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA')) {
                $tramite->estado = 'APROBADO';
                $area = 'NIVEL CENTRAL';
                $motivo = 'TRÁMITE APROBADO';
            } else {
                return back()->with('danger', 'No tiene permisos para aprobar este trámite.');
            }
    
        } elseif ($submitType === 'modificar' && $user->role_id === 1) {
            $maxNumero = Dbrpadb::max('numero');
            $rpadb->numero = ($maxNumero !== null && $maxNumero > 0) ? $maxNumero + 1 : 1;
            $rpadb->fecha_reinscripcion = Carbon::now()->addYears(5)->toDateString(); // MODIFICACIÓN también renueva reinscripción
            $rpadb->finalizado = "1";
    
            if ($tramite->estado === 'APROBADO') {
                // Generar número único para el nuevo expediente
                $nextId = Dbexp::max('id') + 1;
                $exp = new Dbexp();
                $exp->numero = 'EXP-' . str_pad($nextId, 5, '0', STR_PAD_LEFT); // Ejemplo: EXP-01421
                $exp->fecha = now();
                $exp->save();
            
                // Asociar el nuevo expediente al trámite
                $tramite->dbexp_id = $exp->id;
                $tramite->save();
            }                    
    
            $rpadb->save();
    
            $tramite->estado = 'MODIFICADO'; // <--- CAMBIO CLAVE
            $area = 'ADMINISTRADOR';
            $motivo = 'MODIFICACIÓN COMPLETA'; // <--- CAMBIO CLAVE
    
        } else {
            return redirect()->back()->withErrors('Acción no válida.');
        }
    
        // ============================
        // ACTUALIZAR TRÁMITE Y HISTORIAL
        // ============================
        $tramite->observaciones = $request->input('observaciones');
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = $area ?? 'SIN ÁREA DEFINIDA';
        $historial->motivo = $motivo ?? 'SIN MOTIVO DEFINIDO';
        $historial->observaciones = $tramite->observaciones;
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $empresaId;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'El trámite fue actualizado correctamente.');
    }

    public function create_reinscripcion(Request $request)
    {
        $user = Auth::user();
    
        if ($user->role_id !== 15) {
            abort(403, 'No tiene permisos para esta acción.');
        }
    
        $rpadbId = $request->input('rpadb_id');
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($rpadbId);
    
        $empresa = $user->empresa;
        if (!$empresa) {
            return redirect()->back()->withErrors('No tienes una empresa asociada.');
        }
    
        $empresaId = $empresa->id;
    
        $redbs = DB::table('dbredbs')
            ->where('dbempresa_id', $empresaId)
            ->where(function ($q) {
                $q->whereNull('dbbaja_id')->orWhere('dbbaja_id', 0);
            })
            ->orderBy('establecimiento')
            ->get();
    
        $rubros = $rpadb->dbredb->rubros ?? collect();
        $categorias = Dbcategoria::all()->keyBy('id');
    
        return view('db.rpadb.create_reinscripcion', [
            'rpadb' => $rpadb,
            'redbs' => $redbs,
            'rubros' => $rubros,
            'categorias' => $categorias,
            'modoEdicion' => true,
        ]);
    }

    public function store_reinscripcion(Request $request, $id)
    {
        $user = Auth::user();
        $empresa = $user->empresa;
    
        if (!$empresa) {
            return redirect()->back()->withErrors('No hay empresa asociada.');
        }
    
        $empresaId = $empresa->id;
        $rpadb = Dbrpadb::findOrFail($id);
    
        // Crear el nuevo trámite
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'REINSCRIPCION PRODUCTO';
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $empresaId;
        $tramite->factura_id = $request->factura_id ?? null;
        $tramite->dbrpadb_id = $rpadb->id;
        $tramite->save();
    
        // Actualizar campos del producto (como en modificación)
        $rpadb->denominacion = $request->input('denominacion');
        $rpadb->nombre_fantasia = $request->input('nombre_fantasia');
        $rpadb->marca = $request->input('marca');
        $rpadb->dbredb_id = $request->input('productos.0.selected_item_id');
        $rpadb->save();
    
        // Crear carpetas
        $carpeta = "empresa/{$empresaId}/rpadb/{$rpadb->id}";
        $subcarpetas = ['monografia', 'analisis', 'especificaciones', 'pago'];
        foreach ($subcarpetas as $sub) {
            Storage::makeDirectory("{$carpeta}/{$sub}");
        }
    
        // Guardar archivos
        $rpadb->ruta_monografia = json_encode($this->guardarMultiplesArchivos($request, "productos.0.monografia", "{$carpeta}/monografia"));
        $rpadb->ruta_analisis = json_encode($this->guardarMultiplesArchivos($request, "productos.0.analisis", "{$carpeta}/analisis"));
        $rpadb->ruta_especificaciones = json_encode($this->guardarMultiplesArchivos($request, "productos.0.especificaciones", "{$carpeta}/especificaciones"));
    
        if ($request->hasFile("productos.0.pago")) {
            $archivo = $request->file("productos.0.pago");
            $ruta = $archivo->storeAs("{$carpeta}/pago", time() . '-' . $archivo->getClientOriginalName(), 'local');
            $rpadb->ruta_pago = $ruta;
        }
    
        $rpadb->save();
    
        // Actualizar envases
        if (isset($request->productos[0]['envases']) && is_array($request->productos[0]['envases'])) {
            $carpetaEnvases = "{$carpeta}/envases";
            Storage::makeDirectory("{$carpetaEnvases}/certificados");
            Storage::makeDirectory("{$carpetaEnvases}/rotulos");
    
            foreach ($request->productos[0]['envases'] as $envaseId => $envaseData) {
                $envase = new Dbenvase();
                $envase->fill($envaseData);
                $envase->dbrpadb_id = $rpadb->id;
                $envase->save();
    
                if ($request->hasFile("productos.0.envases.{$envaseId}.certificado_envase")) {
                    $this->subirArchivoEnvase(
                        $request->file("productos.0.envases.{$envaseId}.certificado_envase"),
                        $envase,
                        'ruta_cert_envase',
                        "{$carpetaEnvases}/certificados"
                    );
                }
    
                if ($request->hasFile("productos.0.envases.{$envaseId}.rotulo_envase")) {
                    $this->subirArchivoEnvase(
                        $request->file("productos.0.envases.{$envaseId}.rotulo_envase"),
                        $envase,
                        'ruta_rotulo',
                        "{$carpetaEnvases}/rotulos"
                    );
                }
            }
        }
    
        // Registrar historial
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha = Carbon::now();
        $dbhistorial->area = 'PRODUCTOR';
        $dbhistorial->motivo = 'REINSCRIPCION PRODUCTO';
        $dbhistorial->observaciones = 'Se solicita la reinscripción del producto.';
        $dbhistorial->user_id = $user->id;
        $dbhistorial->dbempresa_id = $empresaId;
        $dbhistorial->dbtramite_id = $tramite->id;
        $dbhistorial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'La reinscripción fue registrada correctamente.');
    }    

    public function edit_reinscripcion(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Debe estar autenticado para realizar esta acción.');
        }
    
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        $empresaId = $user->role_id === 15 ? optional($user->empresa)->id : null;
    
        $pivotcat = DB::table('dbredb_dbrubro')
            ->join('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
            ->join('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
            ->join('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
            ->when($empresaId, fn($q) => $q->where('dbredbs.dbempresa_id', $empresaId))
            ->where(function ($q) {
                $q->whereNull('dbbaja_id')->orWhere('dbbaja_id', 0);
            })
            ->select(
                'dbredb_dbrubro.*',
                'dbcategorias.categoria as categoria_nombre',
                'dbrubros.rubro as rubro_nombre',
                'dbredbs.numero as redb_numero'
            )
            ->get();
    
        $tramiteId = $request->input('tramite_id');
        $tramite = $tramiteId
            ? $rpadb->dbtramites()->where('id', $tramiteId)->first()
            : $rpadb->dbtramites()
                ->where('tipo_tramite', 'REINSCRIPCION PRODUCTO')
                ->where('estado', '!=', 'REINSCRIPTO')
                ->latest()
                ->first();
    
        if ($tramiteId && !$tramite) {
            return redirect()->back()->withErrors('El trámite seleccionado no existe o no está asociado a este RPADB.');
        }
    
        $tramiteExistente = Dbtramite::where('tipo_tramite', 'REINSCRIPCION PRODUCTO')
            ->where('estado', '!=', 'REINSCRIPTO')
            ->where('dbrpadb_id', $rpadb->id)
            ->first();
    
        $currentRubroId = $rpadb->dbredb_dbrubro_id ?? null;
        $ultimoHistorial = $tramite ? $tramite->historial()->latest()->first() : null;
    
        $redbs = DB::table('dbredbs')
            ->when($empresaId, fn($q) => $q->where('dbempresa_id', $empresaId))
            ->where(function ($q) {
                $q->whereNull('dbbaja_id')->orWhere('dbbaja_id', 0);
            })
            ->orderBy('establecimiento')
            ->get();
    
        $modoEdicion = ($user->role_id === 15 && $tramite && in_array($tramite->estado, ['INICIADO', 'DEVUELTO']));
    
        $historiales = $tramite
            ? Dbhistorial::where('dbtramite_id', $tramite->id)->orderBy('fecha', 'asc')->with('user')->get()
            : collect();
    
        $rubros = $rpadb->dbredb->rubros ?? collect();
        $categorias = Dbcategoria::all()->keyBy('id');
    
        return view('db.rpadb.edit_reinscripcion', compact(
            'rpadb', 'pivotcat', 'tramite', 'currentRubroId',
            'ultimoHistorial', 'redbs', 'modoEdicion', 'historiales',
            'rubros', 'categorias', 'tramiteExistente'
        ));
    }
    
    public function update_reinscripcion(Request $request, $id)
    {
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        $tramiteId = $request->input('tramite_id');
        $tramite = $tramiteId ? Dbtramite::find($tramiteId) : null;
    
        if (!$tramite) {
            $tramite = new Dbtramite();
            $tramite->tipo_tramite = 'REINSCRIPCION PRODUCTO';
            $tramite->estado = 'INICIADO';
            $tramite->dbempresa_id = $rpadb->dbempresa_id;
            $tramite->dbrpadb_id = $rpadb->id;
            $tramite->save();
        }
    
        $zona = $rpadb->dbredb->localidad->zona ?? null;
        $empresaId = $rpadb->dbempresa_id;
        $submitType = $request->input('submitType');
        $mostrarCampoObservaciones = false;
    
        if ($tramite) {
            if ($user->role_id === 15 && in_array($tramite->estado, ['INICIADO', 'DEVUELTO'])) {
                $mostrarCampoObservaciones = true;
            }
            if (in_array($user->role_id, [16, 17, 18]) && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO A AREA']) && in_array($zona, ['appm', 'ape', 'apcr'])) {
                $mostrarCampoObservaciones = true;
            }
            if ($user->role_id === 9 && (
                ($tramite->estado === 'INICIADO' && $zona === 'nc') ||
                $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA' ||
                ($tramite->estado === 'REENVIADO POR EMPRESA' && $zona === 'nc') ||
                $tramite->estado === 'DEVUELTO A NC'
            )) {
                $mostrarCampoObservaciones = true;
            }
            if ($user->role_id === 1 && $tramite->estado === 'APROBADO') {
                $mostrarCampoObservaciones = true;
            }
        }
    
        if ($mostrarCampoObservaciones) {
            $request->validate([
                'observaciones' => 'required|string|max:1000',
            ]);
        }
    
        if ($user->role_id === 15) {
            $rpadb->denominacion = $request->input('denominacion');
            $rpadb->nombre_fantasia = $request->input('productos.0.nombre_fantasia');
            $rpadb->marca = $request->input('marca');
            $rpadb->dbredb_id = $request->input('productos.0.selected_item_id');
            $rpadb->save();
    
            $this->actualizarArchivos($request, $rpadb);
            $this->actualizarEnvases($request, $rpadb);
        }
    
        if ($user->role_id !== 15) {
            $rpadb->dbredb_dbrubro_id = $request->input('dbredb_dbrubro_id');
            $rpadb->articulo_caa = $request->input('articulo_caa');
            $rpadb->save();
        }
    
        $area = null;
        $motivo = null;
    
        switch ($submitType) {
            case 'reenvio_empresa':
                $tramite->estado = 'REENVIADO POR EMPRESA';
                $area = 'PRODUCTOR';
                $motivo = 'REENVÍO DE INFORMACIÓN';
                break;
    
            case 'evaluado':
                if (in_array($user->role_id, [16, 17, 18]) && in_array($zona, ['appm', 'ape', 'apcr'])) {
                    $tramite->estado = 'EVALUADO POR AREA PROGRAMATICA';
                    $area = 'AREA PROGRAMATICA';
                    $motivo = 'EVALUADO POR ÁREA';
                } else {
                    return back()->with('danger', 'No tiene permisos para realizar esta acción.');
                }
                break;
    
            case 'devolver':
                if ($user->role_id === 1) {
                    $tramite->estado = 'DEVUELTO A NC';
                    $area = 'ADMIN';
                    $motivo = 'DEVUELTO A NIVEL CENTRAL';
                } elseif ($user->role_id === 9) {
                    $tramite->estado = $zona === 'nc' ? 'DEVUELTO' : 'DEVUELTO A AREA';
                    $area = 'NIVEL CENTRAL';
                    $motivo = $zona === 'nc' ? 'DEVUELTO A PRODUCTOR' : 'DEVUELTO A ÁREA';
                } elseif (in_array($user->role_id, [16, 17, 18])) {
                    $tramite->estado = 'DEVUELTO';
                    $area = 'AREA PROGRAMATICA';
                    $motivo = 'DEVUELTO A PRODUCTOR';
                } else {
                    return back()->with('danger', 'No tiene permisos para devolver este trámite.');
                }
                break;
    
            case 'aprobar':
                if ($user->role_id === 9 && ($zona === 'nc' || $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA')) {
                    $tramite->estado = 'APROBADO';
                    $area = 'NIVEL CENTRAL';
                    $motivo = 'TRÁMITE APROBADO';
                } else {
                    return back()->with('danger', 'No tiene permisos para aprobar este trámite.');
                }
                break;
    
            case 'modificar':
                if ($user->role_id === 1) {
                    $rpadb->fecha_reinscripcion = Carbon::now()->addYears(5)->toDateString();
                    $rpadb->finalizado = "1";
    
                    $nextId = Dbexp::max('id') + 1;
                    $exp = new Dbexp();
                    $exp->numero = 'EXP-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
                    $exp->fecha = now();
                    $exp->save();
    
                    $tramite->dbexp_id = $exp->id;
                    $tramite->estado = 'REINSCRIPTO';
                    $area = 'ADMINISTRADOR';
                    $motivo = 'REINSCRIPCIÓN FINALIZADA';
    
                    $rpadb->save();
                }
                break;
    
            default:
                return redirect()->back()->withErrors('Acción no válida.');
        }
    
        $tramite->observaciones = $request->input('observaciones');
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = $area ?? 'SIN ÁREA DEFINIDA';
        $historial->motivo = $motivo ?? 'SIN MOTIVO DEFINIDO';
        $historial->observaciones = $tramite->observaciones;
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $empresaId;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'El trámite fue actualizado correctamente.');
    }

    public function solicitar_baja(Request $request, $id)
    {
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
        $zona = $rpadb->dbredb->localidad->zona ?? null;
    
        // Validación de permiso según zona
        if ($zona === 'NC' && $user->role_id !== 9) {
            abort(403);
        } elseif ($zona !== 'NC' && !in_array($user->role_id, [15, 16, 17, 18])) {
            abort(403);
        }
    
        $request->validate([
            'observaciones' => 'required|string|max:1000',
        ]);
    
        $tramite = new Dbtramite();
        $tramite->fecha_inicio = Carbon::now();
        $tramite->tipo_tramite = 'BAJA PRODUCTO';
        $tramite->estado = 'INICIADO';
        $tramite->dbempresa_id = $rpadb->dbempresa_id;
        $tramite->dbrpadb_id = $rpadb->id;
        $tramite->observaciones = $request->input('observaciones');
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = $this->obtenerNombreRol($user->role_id);
        $historial->motivo = 'BAJA PRODUCTO';
        $historial->observaciones = 'Solicitud de baja: ' . $rpadb->denominacion;
        $historial->user_id = $user->id;
        $historial->dbempresa_id = $rpadb->dbempresa_id;
        $historial->dbrpadb_id = $rpadb->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'La solicitud de baja fue iniciada correctamente.');
    }
    
    public function create_baja($id)
    {
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbempresa', 'dbredb.localidad', 'dbbaja')->findOrFail($id);
        $tramite = Dbtramite::where('dbrpadb_id', $rpadb->id)
                            ->where('tipo_tramite', 'BAJA PRODUCTO')
                            ->latest()
                            ->first();
    
        if (!$tramite) {
            abort(404, 'No se encontró trámite de baja para este producto.');
        }
    
        $zona = $rpadb->dbredb->localidad->zona ?? null;
    
        // Validación de acceso
        if ($user->role_id === 1) {
            if ($tramite->estado !== 'APROBADO') {
                abort(403, 'Solo puede registrar la baja cuando el trámite esté aprobado.');
            }
        } elseif ($user->role_id === 9) {
            if (!in_array($tramite->estado, ['INICIADO', 'EVALUADO POR AREA PROGRAMATICA'])) {
                abort(403, 'Este trámite no puede ser aprobado en su estado actual.');
            }
        } elseif (in_array($user->role_id, [16, 17, 18])) {
            if (!($zona !== 'NC' && $tramite->estado === 'INICIADO')) {
                abort(403, 'Este trámite no puede ser evaluado por el área.');
            }
        } else {
            abort(403, 'No tiene permisos para gestionar esta baja.');
        }
    
        return view('db.rpadb.create_baja', compact('rpadb', 'tramite'));
    }    
    
    public function store_baja(Request $request, $id)
    {
        $user = Auth::user();
        $rpadb = Dbrpadb::with('dbredb.localidad')->findOrFail($id);
    
        $tramite = Dbtramite::where('dbrpadb_id', $rpadb->id)
                            ->where('tipo_tramite', 'BAJA PRODUCTO')
                            ->latest()->first();
    
        if ($user->role_id !== 1 || $tramite->estado !== 'APROBADO') {
            abort(403);
        }
    
        $request->validate([
            'fecha_baja' => 'required|date',
            'caja' => 'nullable|string|max:255',
            'motivo' => 'required|string|max:1000',
            'expediente' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'solicito' => 'nullable|string|max:255',
        ]);
    
        $numero_siguiente = (Dbbaja::max('numero') ?? 0) + 1;
    
        $baja = new Dbbaja();
        $baja->numero = $numero_siguiente;
        $baja->fecha_baja = $request->input('fecha_baja');
        $baja->caja = $request->input('caja');
        $baja->motivo = $request->input('motivo');
        $baja->expediente = $request->input('expediente');
        $baja->solicito = $request->input('solicito');
        $baja->nro_registro = $rpadb->numero;
        $baja->establecimiento = $rpadb->denominacion;
        $baja->user_id = $user->id;
        $baja->save();
    
        $rpadb->dbbaja_id = $baja->id;
        $rpadb->fecha_baja = $request->input('fecha_baja');
        $rpadb->finalizado = 1;
        $rpadb->save();
    
        $tramite->estado = 'FINALIZADO';
        $tramite->finalizado = 1;
        $tramite->dbexp_id = $this->obtenerOcrearExpediente($request->input('expediente'));
        $tramite->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'La baja fue registrada correctamente.');
    }
    
    public function evaluar_baja($id)
    {
        $user = Auth::user();
    
        if (!in_array($user->role_id, [16, 17, 18])) {
            abort(403);
        }
    
        $tramite = Dbtramite::where('dbrpadb_id', $id)
                            ->where('tipo_tramite', 'BAJA PRODUCTO')
                            ->latest()->first();
    
        if (!$tramite) {
            return redirect()->back()->withErrors('Trámite no encontrado.');
        }
    
        $tramite->estado = 'EVALUADO POR AREA PROGRAMATICA';
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = $this->obtenerNombreRol($user->role_id);
        $historial->motivo = 'Evaluación de baja';
        $historial->observaciones = 'Trámite evaluado por el área.';
        $historial->user_id = $user->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->dbempresa_id = $tramite->dbempresa_id; // 🔥 Esta línea es la que soluciona el error
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'El trámite fue evaluado por el área.');
    }
    
    
    public function aprobar_baja(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role_id !== 9) {
            abort(403);
        }
    
        $tramite = Dbtramite::where('dbrpadb_id', $id)
                            ->where('tipo_tramite', 'BAJA PRODUCTO')
                            ->latest()
                            ->first();
    
        if (!$tramite || in_array($tramite->estado, ['APROBADO', 'FINALIZADO'])) {
            return redirect()->back()->with('notification', 'El trámite ya fue aprobado o finalizado.');
        }
    
        $tramite->estado = 'APROBADO';
        $tramite->save();
    
        $historial = new Dbhistorial();
        $historial->fecha = Carbon::now();
        $historial->area = 'NIVEL CENTRAL';
        $historial->motivo = 'Aprobación de baja de producto';
        $historial->observaciones = 'Trámite aprobado para baja del producto';
        $historial->user_id = $user->id;
        $historial->dbtramite_id = $tramite->id;
        $historial->dbempresa_id = $tramite->dbempresa_id; // 🔥 ESTA LÍNEA ES LA QUE FALTABA
        $historial->dbrpadb_id = $tramite->dbrpadb_id; // 🔥 Y esta también para tener relación completa
        $historial->save();
    
        return redirect()->route('db_tramites_index')->with('notification', 'El trámite fue aprobado por Nivel Central.');
    }
    
    
    private function obtenerOcrearExpediente($numero)
    {
        $exp = Dbexp::where('numero', $numero)->first();
        if ($exp) {
            return $exp->id;
        }
        $nuevo = new Dbexp();
        $nuevo->numero = $numero;
        $nuevo->fecha = Carbon::now();
        $nuevo->save();
        return $nuevo->id;
    }
    
    private function obtenerNombreRol($role_id)
    {
        $nombres = [
            1 => 'ADMIN',
            9 => 'NIVEL CENTRAL',
            15 => 'PRODUCTOR',
            16 => 'AREA ESQUEL',
            17 => 'AREA COMODORO RIVADAVIA',
            18 => 'AREA PUERTO MADRYN',
        ];
        return $nombres[$role_id] ?? 'USUARIO';
    }

}
