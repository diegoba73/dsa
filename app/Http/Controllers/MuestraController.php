<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ValidarFormularioRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DbExport;
use App\Exports\DsbExport;
use App\Exports\DsoExport;
use App\Exports\DlExport;
use App\Exports\ClienteExport;
use App\User;
use App\Role;
use App\Departamento;
use App\Matriz;
use App\Tipomuestra;
use App\Muestra;
use App\Remitente;
use App\Localidad;
use App\Provincia;
use App\Ensayo;
use App\Analito;
use App\Factura;
use App\Nomenclador;
use Carbon\Carbon;
use \PDF;
use Session;
use Google\Cloud\Translate\TranslateClient;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MuestraController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


     public function index(Request $request)
     {
         $user = Auth::user();
     
         // Definir los filtros que vamos a utilizar
         $filters = $request->only([
             'id', 'numero', 'tipo_muestra', 'muestra', 'lugar_extraccion',
             'identificacion', 'lote', 'remitente', 'departamento', 'cargada',
             'pendiente', 'cromatografia', 'quimica', 'ensayo_biologico',
             'microbiologia', 'fecha_entrada_inicio', 'fecha_entrada_final',
             'factura'
         ]);
     
         // Construir la consulta utilizando los filtros y el usuario actual
         $muestras = $this->buildMuestraQuery($user, $filters)->paginate(50);
     
         // Obtener los datos necesarios para las listas desplegables en la vista
         $remitentes = Remitente::all();
         $departamentos = Departamento::all();
         $nomencladors = Nomenclador::all();
     
         // Añadimos la variable $year que necesita la vista
         $year = date('Y');
     
         // Pasar los filtros a la vista para mantener los valores en el formulario
         return view('lab.muestras.index', compact(
             'muestras', 'remitentes', 'departamentos', 'filters', 'year', 'nomencladors'
         ));
     }     
     
 
     private function buildMuestraQuery($user, $filters)
     {
        \Log::info('Filtros recibidos', $filters);

         $muestras = Muestra::with('remitente')->orderBy('muestras.id', 'DESC');
     
         // Aplicar filtros generales (scopes)
         foreach ($filters as $key => $value) {
             if (!empty($value)) {
                 $method = camel_case($key);
                 if (method_exists($muestras->getModel(), 'scope' . ucfirst($method))) {
                     $muestras = $muestras->$method($value);
                 }
             }
         }
     
         // Filtrar por fechas
         if (!empty($filters['fecha_entrada_inicio'])) {
             $muestras->whereDate('fecha_entrada', '>=', $filters['fecha_entrada_inicio']);
         }
         if (!empty($filters['fecha_entrada_final'])) {
             $muestras->whereDate('fecha_entrada', '<=', $filters['fecha_entrada_final']);
         }
     
         // Departamentos
         $dlDepartmentId  = Departamento::where('departamento', 'DL')->value('id');
         $dsbDepartmentId = Departamento::where('departamento', 'DSB')->value('id');
         $dsoDepartmentId = Departamento::where('departamento', 'DSO')->value('id');
         $dsaDepartmentId = Departamento::where('departamento', 'DSA')->value('id');
     
         // Roles
         $adminRoleId     = Role::where('name', 'Admin')->value('id');
         $clienteRoleIds  = Role::whereIn('name', ['Cliente', 'Institucion'])->pluck('id')->toArray();
     
         // Filtros por acceso
         if (in_array($user->role_id, $clienteRoleIds)) {
             $muestras->whereHas('remitente', function ($query) use ($user) {
                 $query->where('user_id', $user->id);
             });
         } elseif ($user->departamento_id == $dlDepartmentId) {
             switch ($user->role_id) {
                 case 1: // Admin
                 case 2: // Admin Lab
                     break;
     
                 case 3: // F.Q. Alimentos
                     $muestras->where('matriz_id', '!=', 3)
                              ->where(function ($q) {
                                  $q->where('quimica', 1)
                                    ->orWhereHas('ensayos', function ($query) {
                                        $query->where('tipo_ensayo', 'Físico/Químico');
                                    });
                              });
                     break;
     
                 case 4: // F.Q. Aguas
                     $muestras->whereIn('matriz_id', [3, 4, 10, 14, 15])
                              ->where(function ($q) {
                                  $q->where('quimica', 1)
                                    ->orWhereHas('ensayos', function ($query) {
                                        $query->where('tipo_ensayo', 'Físico/Químico');
                                    });
                              });
                     break;
     
                 case 5: // Ensayo Biológico
                     $muestras->where(function ($q) {
                         $q->where('ensayo_biologico', 1)
                           ->orWhereHas('ensayos', function ($query) {
                               $query->where('tipo_ensayo', 'Ensayo Biológico');
                           });
                     });
                     break;
     
                 case 6: // Cromatografía
                     $muestras->where(function ($q) {
                         $q->where('cromatografia', 1)
                           ->orWhereHas('ensayos', function ($query) {
                               $query->where('tipo_ensayo', 'Cromatografía');
                           });
                     });
                     break;
     
                 case 7: // Microbiología
                     $muestras->where(function ($q) {
                         $q->where('microbiologia', 1)
                           ->orWhereHas('ensayos', function ($query) {
                               $query->where('tipo_ensayo', 'Microbiológico');
                           });
                     });
                     break;
     
                 case 8: // Calidad
                     break;
     
                 default:
                     $muestras->whereRaw('1 = 0');
                     break;
             }
         } elseif ($user->departamento_id == $dsaDepartmentId) {
             // Sin restricciones
         } elseif ($user->departamento_id == $dsoDepartmentId && $user->role_id == $adminRoleId) {
             $muestras->whereIn('departamento_id', [$dsoDepartmentId, $dsbDepartmentId]);
         } else {
             $muestras->where('departamento_id', $user->departamento_id);
         }
     
         // Filtro de factura (se aplica para todos)
         if (isset($filters['factura'])) {
            \Log::info('Aplicando filtro de factura', ['factura' => $filters['factura']]);
            $muestras->factura($filters['factura']);
        }

         return $muestras;
     }
        

    public function aceptar (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->aceptada = '1';
        $muestra->save();
        $notification = 'La muestra fué ACEPTADA correctamente.';
        return back()->with(compact('notification'));
    }

    public function devolver (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->aceptada = null;
        $muestra->cargada = "0";
        $muestra->revisada = null;
        $muestra->remitir = null;
        $muestra->fecha_salida = null;
        $muestra->save();
        $notification = 'La muestra fué DEVUELTA correctamente.';
        return back()->with(compact('notification'));
    }

    public function revisada (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->revisada = '1';
        $muestra->save();
        $notification = 'La muestra fué REVISADA correctamente.';
        return back()->with(compact('notification'));
    }

    public function vrevisar (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->revisada = NULL;
        $muestra->traducida = NULL;
        $muestra->condicion = "Sin/Conclusión";
        $muestra->save();
        $notification = 'La muestra fué colocada para su revisión nuevamente.';
        return back()->with(compact('notification'));
    }

    public function traducir (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->traducida = '1';
        $muestra->save();
        $notification = 'La muestra fué TRADUCIDA correctamente.';
        return back()->with(compact('notification'));
    }

    public function show($id)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
    
        if (($user->role_id === 13 || $user->role_id === 14)) {
            $remitente = Remitente::where('user_id', $user->id)->first(); // Buscar el remitente asociado al usuario
        } else {
            $remitente = null;
        }
        $muestra = Muestra::find($id);
        $departamento = Departamento::all();
        $provincia = Provincia::all();
        $localidad = Localidad::all();        
        $remitentes = Remitente::all();
        $matriz = Matriz::all();
        $tipomuestra = Tipomuestra::all();
        $ensayos = Ensayo::orderBy('id', 'ASC')->get();
        return view('lab.muestras.show')->with(compact('muestra', 'tipomuestra', 'remitente', 'remitentes', 'matriz', 'departamento', 'provincia', 'localidad', 'ensayos')); // listado
    } 

    public function ht($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $departamento = Departamento::pluck('departamento');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $ensayos = Ensayo::all();
        $user = User::all();
        return view('lab.muestras.ht')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'matriz', 'tipomuestra', 'departamento', 'user')); // imprimir
    } 

    public function frechazo($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $url = redirect()->getUrlGenerator()->previous();  
        return view('lab.muestras.frechazo')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'url', 'matriz', 'tipomuestra')); 
        
    } 

    public function urechazo(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'criterio_rechazo' => 'required|string|max:255',
        ]);

        // Obtener y actualizar la muestra
        $muestra = Muestra::findOrFail($id);
        $muestra->criterio_rechazo = $request->input('criterio_rechazo');
        $muestra->aceptada = '0';
        $muestra->cargada = '0';
        $muestra->save(); // Insert rechazo

        // Definir el mensaje de notificación
        $notification = 'La muestra fue RECHAZADA.';

        // Obtener el historial de URLs
        $urlHistory = $request->session()->get('url_history', []);

        // Verificar si hay al menos 3 URLs (incluyendo la actual)
        if (count($urlHistory) >= 3) {
            // La primera URL es la actual, la segunda es una vuelta atrás, la tercera es dos vueltas atrás
            $url = $urlHistory[2];
        } elseif (count($urlHistory) >= 2) {
            // Si no hay tres URLs, redirigir una vuelta atrás
            $url = $urlHistory[1];
        } else {
            // Si no hay suficiente historial, redirigir a una ruta por defecto
            $url = route('muestras.index');
        }

        return redirect($url)->with('notification', $notification);
    }

    public function imprimir_rechazo($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $ensayos = Ensayo::all();
        $muestra->fecha_salida = Carbon::now();
        $muestra->save();
        return view('lab.muestras.imprimir_rechazo')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'matriz', 'tipomuestra')); // imprimir
    } 

    public function fresultado($id)
    {
        $muestra = Muestra::find($id);
        $ensayos = Ensayo::all();  
        $matriz = Matriz::all();  
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $analitos = Analito::where('muestra_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        Session::put('url', $url);
        return view('lab.muestras.fresultado')->with(compact('muestra', 'ensayos', 'analitos', 'url', 'matriz', 'tipomuestra')); 
        
    } 

    public function uresultado(Request $request, $id)
    {
        // 1. Recuperar la muestra
        $muestra = Muestra::findOrFail($id);
    
        // 2. Guardar fechas de análisis y observaciones
        $muestra->fecha_inicio_analisis = $request->input('fecha_inicio_analisis');
        $muestra->fecha_fin_analisis    = $request->input('fecha_fin_analisis');
        $muestra->cargada               = 1;
        $muestra->observaciones         = $request->input('observaciones');
        $muestra->save();
    
        // 3. Preparar datos para el pivot sin eliminar los existentes
        $ensayoIds  = $request->input('ensayo_id', []);
        $resultados = $request->input('resultado', []);
        $syncData   = [];
    
        foreach ($ensayoIds as $index => $ensayoId) {
            $syncData[$ensayoId] = [
                'resultado' => $resultados[$index]
            ];
        }
    
        // 4. Sincronizar sin desprender (no elimina pivots que no estén en $syncData)
        $muestra->ensayos()->syncWithoutDetaching($syncData);
    
        // 5. Redirigir con mensaje
        $notification = 'Se cargaron exitosamente los RESULTADOS de la Muestra.';
        return redirect()->route('lab_muestras_index')
                         ->with(compact('notification'));
    }    


    public function imprimir_resultado($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $analitos = Analito::where('muestra_id', $id)->get();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $muestra->fecha_salida = Carbon::now();
        $muestra->save();
        return view('lab.muestras.imprimir_resultado')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'analitos', 'matriz', 'tipomuestra')); // imprimir
    } 

    public function imprimir_resultado_firma($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $analitos = Analito::where('muestra_id', $id)->get();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $muestra->fecha_salida = Carbon::now();
        $muestra->save();
        return view('lab.muestras.imprimir_resultado_firma')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'analitos', 'matriz', 'tipomuestra')); // imprimir
    } 

    public function imprimir_traducido($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $analitos = Analito::where('muestra_id', $id)->get();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $muestra->fecha_salida = Carbon::now();
        $muestra->save();
        return view('lab.muestras.imprimir_traducido')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'analitos', 'matriz', 'tipomuestra')); // imprimir
    } 

    public function imprimir_traducido_firma($id)
    {
        $muestra = Muestra::find($id);
        $provincia = Provincia::pluck('provincia');
        $localidad = Localidad::pluck('localidad');        
        $remitente = Remitente::pluck('nombre');
        $matriz = Matriz::pluck('matriz');
        $tipomuestra = Tipomuestra::pluck('tipo_muestra');
        $analitos = Analito::where('muestra_id', $id)->get();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $muestra->fecha_salida = Carbon::now();
        $muestra->save();
        return view('lab.muestras.imprimir_traducido_firma')->with(compact('muestra', 'remitente', 'localidad', 'provincia', 'ensayos', 'analitos', 'matriz', 'tipomuestra')); // imprimir
    } 

    public function getEnsayos($id){
        return Ensayo::where('matriz_id', $id)->get();
    }

    public function getTipomuestras($id){
        return Tipomuestra::where('matriz_id', $id)->get();
    }

    public function getLocalidades($id){
        return Localidad::where('provincia_id', $id)->get();
    }

    public function create(Request $request)
    {

        $user = auth()->user(); // Obtener el usuario autenticado
    
        if (($user->role_id === 13 || $user->role_id === 14)) {
            $remitentes = Remitente::where('user_id', $user->id)->get(); // Buscar el remitente asociado al usuario
        } else {
            $remitentes = Remitente::all();
        }
        $provincias = Provincia::all();
        $localidads = Localidad::all();        
        $tipomuestras = Tipomuestra::all();
        $matrizs = Matriz::all();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $ensayosActivos = Ensayo::where('activo', 1)->get(); 
        return view('lab.muestras.create')->with(compact('remitentes', 'localidads', 'provincias', 'ensayosActivos', 'matrizs', 'tipomuestras'));  // formulario muestra
    }


    public function store(Request $request)
    {
        $this->validateMuestra($request);

        $ingresos = $request->input('ingresos', 1);

        for ($i = 1; $i <= $ingresos; $i++) {
            $muestra = new Muestra();
            $this->fillMuestraAttributes($muestra, $request);
            $muestra->save();

            // Sincronizar ensayos
            $ensayos = $request->input('ensayo_id', []);
            $muestra->ensayos()->sync($ensayos);
        }

        $notification = $ingresos == 1
            ? 'La muestra fue INGRESADA correctamente.'
            : 'Las muestras fueron INGRESADAS correctamente.';

        return redirect('/lab/muestras/index')->with(compact('notification'));
    }

    public function edit($id)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $remitente = null;
        
        // Obtener el remitente si el usuario es cliente (role_id 13 o 14)
        if (($user->role_id === 13 || $user->role_id === 14)) {
            $remitentes = Remitente::where('user_id', $user->id)->get(); // Buscar el remitente asociado al usuario
        } else {
            $remitentes = Remitente::all();
        }
    
        // Condición para permitir acceso según el rol del usuario
        if (in_array($user->role_id, [1, 12, 8, 13, 14])) {
            // Acceso completo a la muestra
            $muestra = Muestra::findOrFail($id);
        } else {
            // Acceso restringido por departamento
            $muestra = Muestra::where('muestras.departamento_id', '=', $user->departamento_id)->findOrFail($id);
        }
    
        // Obtener los datos necesarios para la vista
        $localidads = Localidad::all();
        $provincias = Provincia::all();         
        $matrizs = Matriz::all();
        $tipomuestras = Tipomuestra::all();
        $matriz = Matriz::pluck('matriz');
        $ensayos = Ensayo::orderBy('codigo')->where('matriz_id', $muestra->matriz_id)->get();
        $selects = DB::table('ensayo_muestra')->where('muestra_id', $id)->get();
        
        // Para obtener la URL previa
        $url = redirect()->getUrlGenerator()->previous();
        
        // Retornar la vista con los datos correspondientes
        return view('lab.muestras.edit')->with(compact('muestra', 'remitente', 'remitentes', 'localidads', 'provincias', 'matrizs', 'matriz', 'tipomuestras', 'ensayos', 'selects', 'url', 'user'));  
    }    


    public function update(Request $request, $id)
    {
        $this->validateMuestra($request);

        $muestra = Muestra::findOrFail($id);
        $this->fillMuestraAttributes($muestra, $request, true);
        $muestra->save();

        // Sincronizar ensayos
        $ensayos = $request->input('ensayo_id', []);
        $muestra->ensayos()->sync($ensayos);

        $notification = 'La muestra fue ACTUALIZADA correctamente.';
        return redirect()->route('lab_muestras_index')->with(compact('notification'));
    }

    private function validateMuestra(Request $request)
    {
        $rules = [
            'matriz_id' => 'required',
            'tipomuestra_id' => 'required',
            'muestra' => 'required',
            'fecha_extraccion' => 'required',
            'localidad_id' => 'required',
            'provincia_id' => 'required',
        ];
    
        if (in_array(auth()->user()->role_id, [13, 14])) {
            $rules['entrada_hidden'] = 'required';
            $rules['tipo_prestacion_hidden'] = 'required';
            $rules['remitente'] = 'required|exists:remitentes,id';
            $rules['solicitante'] = 'required|string|max:255';
        } else {
            $rules['entrada'] = 'required';
            $rules['tipo_prestacion'] = 'required';
            $rules['remitente'] = 'required|exists:remitentes,id';
            $rules['solicitante'] = 'required|string|max:255';
        }
    
        $messages = [
            'matriz_id.required' => 'Se necesita la Matriz',
            'tipomuestra_id.required' => 'Se necesita el Tipo de Muestra',
            'muestra.required' => 'Se necesita describir la Muestra',
            'fecha_extraccion.required' => 'Se necesita la fecha de extracción',
            'localidad_id.required' => 'Se necesita la Localidad',
            'provincia_id.required' => 'Se necesita la Provincia',
            'remitente.required' => 'Se necesita el dato del Remitente',
            'remitente.exists' => 'El remitente seleccionado no es válido',
            'solicitante.required' => 'Se necesita el dato del Solicitante',
            'solicitante.exists' => 'El solicitante seleccionado no es válido',
            'entrada_hidden.required' => 'Se necesita el dato del Tipo de Entrada',
            'tipo_prestacion_hidden.required' => 'Se necesita el dato del Tipo de Prestación',
            'entrada.required' => 'Se necesita el dato del Tipo de Entrada',
            'tipo_prestacion.required' => 'Se necesita el dato del Tipo de Prestación',
        ];
    
        $this->validate($request, $rules, $messages);
    }
    

    /*     private function fillMuestraAttributes(Muestra $muestra, Request $request, $isUpdate = false)
        {
            $user = auth()->user();

            if (in_array($user->role_id, [13, 14])) {
                $muestra->entrada = $request->input('entrada_hidden');
                $muestra->tipo_prestacion = $request->input('tipo_prestacion_hidden');
                if (!$isUpdate) {
                    $muestra->remitente_id = $request->input('remitente');
                    $muestra->solicitante = $request->input('solicitante');
                }
            } else {
                $muestra->entrada = $request->input('entrada');
                $muestra->tipo_prestacion = $request->input('tipo_prestacion');
                $muestra->remitente_id = $request->input('remitente');
                $muestra->solicitante = $request->input('solicitante');
            }

            if (!$isUpdate) {
                // Generar número secuencial
                $ultimoRegistro = Muestra::orderBy('id', 'desc')->first();
                $ultimoAno = $ultimoRegistro ? Carbon::parse($ultimoRegistro->fecha_entrada)->year : Carbon::now()->year;
                $anoActual = Carbon::now()->year;
                $numeroSiguiente = ($ultimoAno == $anoActual && $ultimoRegistro) ? $ultimoRegistro->numero + 1 : 1;
                $muestra->numero = $numeroSiguiente;
            }

            $muestra->matriz_id = $request->input('matriz_id');
            $muestra->tipomuestra_id = $request->input('tipomuestra_id');
            $muestra->muestra = $request->input('muestra');
            $muestra->nro_cert_cadena_custodia = $request->input('cadena_custodia');
            $muestra->identificacion = $request->input('identificacion');
            $muestra->fecha_entrada = $request->input('fecha_entrada');
            $muestra->realizo_muestreo = $request->input('realizo_muestreo');
            $muestra->localidad_id = $request->input('localidad_id');
            $muestra->provincia_id = $request->input('provincia_id');
            $muestra->lugar_extraccion = $request->input('lugar_extraccion');
            $muestra->fecha_extraccion = $request->input('fecha_extraccion');
            $muestra->hora_extraccion = $request->input('hora_extraccion');
            $muestra->conservacion = $request->input('conservacion');
            $muestra->cloro_residual = $request->input('cloro_residual');
            $muestra->elaborado_por = $request->input('elaborado');
            $muestra->domicilio = $request->input('domicilio');
            $muestra->marca = $request->input('marca');
            $muestra->tipo_envase = $request->input('tipo_envase');
            $muestra->cantidad = $request->input('cantidad');
            $muestra->peso_volumen = $request->input('peso_volumen');
            $muestra->fecha_elaborado = $request->input('fecha_elaborado');
            $muestra->fecha_vencimiento = $request->input('fecha_vencimiento');
            $muestra->registro_establecimiento = $request->input('registro_est');
            $muestra->registro_producto = $request->input('registro_prod');
            $muestra->lote = $request->input('lote');
            $muestra->partida = $request->input('partida');
            $muestra->destino = $request->input('destino');
            $muestra->aceptada = $request->input('aceptada', null);
            $muestra->condicion = 'Sin/Conclusión';
            $muestra->cargada = 0;
            $muestra->user_id = $user->id;

            // Asignar departamento si corresponde
            $ensayos = $request->input('ensayo_id', []);
            if (in_array(285, $ensayos) || in_array(286, $ensayos) || in_array(251, $ensayos)) {
                $muestra->departamento_id = 2;
            } else {
                $muestra->departamento_id = $request->input('departamento_id', $user->departamento_id);
            }
        } */

    private function fillMuestraAttributes(Muestra $muestra, Request $request, $isUpdate = false)
    {
        $user = auth()->user();

        // --- Asignación condicional por ROL (entrada, tipo_prestacion, remitente, solicitante) ---
        if (in_array($user->role_id, [13, 14])) { // Roles Cliente/Institucion
            $muestra->entrada = $request->input('entrada_hidden');
            $muestra->tipo_prestacion = $request->input('tipo_prestacion_hidden');
            // Nota: Si un cliente edita, no puede cambiar remitente ni solicitante aquí.
            $muestra->remitente_id = $request->input('remitente');
            $muestra->solicitante = $request->input('solicitante');
        } else { // Otros roles
            $muestra->entrada = $request->input('entrada');
            $muestra->tipo_prestacion = $request->input('tipo_prestacion');
            // Permitir cambiar remitente/solicitante en la edición para otros roles
            $muestra->remitente_id = $request->input('remitente');
            $muestra->solicitante = $request->input('solicitante');
        }

        // --- Lógica y valores SOLO para CREACIÓN (!isUpdate) ---
        if (!$isUpdate) {
            // Generar número secuencial
            $ultimoRegistro = Muestra::orderBy('id', 'desc')->first();
            $ultimoAno = $ultimoRegistro ? Carbon::parse($ultimoRegistro->fecha_entrada)->year : Carbon::now()->year;
            $anoActual = Carbon::now()->year;
            $numeroSiguiente = ($ultimoAno == $anoActual && $ultimoRegistro) ? $ultimoRegistro->numero + 1 : 1;
            $muestra->numero = $numeroSiguiente;

            // Inicializar Estados Clave al crear
            $muestra->aceptada = null;        // Estado inicial: pendiente de aceptación/rechazo
            $muestra->cargada = 0;           // Estado inicial: resultados no cargados
            $muestra->revisada = null;       // Estado inicial: no revisada
            $muestra->traducida = null;      // Estado inicial: no traducida
            $muestra->condicion = 'Sin/Conclusión'; // Estado inicial de condición

            // Otros campos que solo se establecen al crear (si los hubiera)
            // $muestra->campo_solo_creacion = ...;
        }

        // --- Asignación de DATOS DESCRIPTIVOS (Común para Crear y Actualizar) ---
        // Estos son los campos que típicamente se editan en el formulario principal.
        $muestra->matriz_id = $request->input('matriz_id');
        $muestra->tipomuestra_id = $request->input('tipomuestra_id');
        $muestra->muestra = $request->input('muestra');
        $muestra->nro_cert_cadena_custodia = $request->input('cadena_custodia');
        $muestra->identificacion = $request->input('identificacion');
        $muestra->fecha_entrada = $request->input('fecha_entrada'); // ¿Debería poder cambiarse post-creación? Evaluar.
        $muestra->realizo_muestreo = $request->input('realizo_muestreo');
        $muestra->localidad_id = $request->input('localidad_id');
        $muestra->provincia_id = $request->input('provincia_id');
        $muestra->lugar_extraccion = $request->input('lugar_extraccion');
        $muestra->fecha_extraccion = $request->input('fecha_extraccion');
        $muestra->hora_extraccion = $request->input('hora_extraccion');
        $muestra->conservacion = $request->input('conservacion');
        $muestra->cloro_residual = $request->input('cloro_residual');
        $muestra->elaborado_por = $request->input('elaborado');
        $muestra->domicilio = $request->input('domicilio');
        $muestra->marca = $request->input('marca');
        $muestra->tipo_envase = $request->input('tipo_envase');
        $muestra->cantidad = $request->input('cantidad');
        $muestra->peso_volumen = $request->input('peso_volumen');
        $muestra->fecha_elaborado = $request->input('fecha_elaborado');
        $muestra->fecha_vencimiento = $request->input('fecha_vencimiento');
        $muestra->registro_establecimiento = $request->input('registro_est');
        $muestra->registro_producto = $request->input('registro_prod');
        $muestra->lote = $request->input('lote');
        $muestra->partida = $request->input('partida');
        $muestra->destino = $request->input('destino');
        // IMPORTANTE: NO TOCAR los estados 'aceptada', 'cargada', 'revisada', 'traducida' aquí
        // 'condicion' tampoco se toca aquí, se maneja en su propio método o en la inicialización.

        // --- Lógica de Asignación de Departamento (Común para Crear y Actualizar) ---
        // Se asume que el departamento PUEDE cambiar o corregirse post-creación si cambian los ensayos.
        $ensayos = $request->input('ensayo_id', []);
        // Comprueba si alguno de los ensayos específicos fuerza el departamento 2
        if (count(array_intersect([285, 286, 251], $ensayos)) > 0) {
            $muestra->departamento_id = 2;
        } else {
            // Si no, toma el departamento del request o el del usuario como fallback.
            $muestra->departamento_id = $request->input('departamento_id', $user->departamento_id);
        }

        // --- Usuario que realiza la acción (Crear o Actualizar) ---
        // Refleja quién fue el último en guardar cambios en esta muestra.
        $muestra->user_id = $user->id;

        // Nota: Los Ensayos se sincronizan fuera de este método, en store() y update(), lo cual es correcto.
    }

    public function exportDbExcel(Request $request)
    {
        $year = $request->input('year');
        return Excel::download(new DbExport($year), 'consulta-muestras.xlsx');
    }

    public function exportDsbExcel(Request $request)
    {
        $year = $request->input('year');
        return Excel::download(new DsbExport($year), 'consulta-muestras.xlsx');
    }

    public function exportDlExcel(Request $request)
    {
        $year = $request->input('year');
        return Excel::download(new DlExport($year), 'consulta-muestras.xlsx');
    }

    public function exportDsoExcel(Request $request)
    {
        $year = $request->input('year');
        return Excel::download(new DsoExport($year), 'consulta-muestras.xlsx');
    }

    public function exportClienteExcel(Request $request)
    {
        $year = $request->input('year');
        $userId = auth()->user()->id; // Obtén el ID del usuario logueado

        return Excel::download(new ClienteExport($year, $userId), 'consulta-muestras.xlsx');
    }

    public function firma(Request $request)
    {
        $id       = $request->get('id');
        $numero       = $request->get('numero');
        if ((Auth::user()->role_id == 1)&&(Auth::user()->departamento_id == 1)){

                    $muestras = Muestra::with('remitente')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->where('cargada', 1)
                    ->where('aceptada', 1)
                    ->where('revisada', 0)
                    ->numero($numero)
                    ->paginate(50);
            } 
        $remitentes = Remitente::all();
        $matrizs = Matriz::all();
        $departamentos = Departamento::all();
        return view('lab.muestras.firma')->with(compact('muestras', 'remitentes', 'matrizs', 'departamentos')); // listado
    }

    public function batchAction(Request $request)
    {
        $action = $request->input('action');
    
        if ($action === 'batchAction') {
            $selected = $request->input('selected', []);
            if (empty($selected)) {
                session()->flash('danger', 'No se han seleccionado registros.');
                return back();
            }
    
            foreach ($selected as $id) {
                $muestra = Muestra::find($id);
                if ((!$muestra->cargada !== false) || ($muestra->revisada !== null)) {
                    session()->flash('danger', 'La muestra ' . $muestra->numero . ' no se puede marcar como revisada porque no están cargados los resultados o bien ya fue revisada.');
                    return back();
                }
                $muestra->update(['revisada' => true]);
            }
    
            return back()->with('notification', 'Las muestras fueron REVISADAS correctamente.');
        }
    
        if ($action === 'generarFactura') {
            $selected = $request->input('selected', []);
            if (empty($selected)) {
                session()->flash('danger', 'No se han seleccionado registros.');
                return back();
            }
    
            $muestras = Muestra::with(['remitente', 'ensayos'])->whereIn('id', $selected)->get();
    
            $remitentes = $muestras->pluck('remitente.id')->unique();
            if ($remitentes->count() > 1) {
                session()->flash('danger', 'No se pueden facturar muestras de diferentes remitentes en una misma factura.');
                return back();
            }
    
            $departamentos = $muestras->pluck('departamento_id')->unique();
            if ($departamentos->count() !== 1) {
                session()->flash('danger', 'Hay muestras de distintos departamentos. No se puede asignar un departamento a la factura.');
                return back();
            }
    
            $factura = new Factura();
            $factura->remitentes_id = $remitentes->first();
            $factura->fecha_emision = now();
            $factura->fecha_vencimiento = now()->addDays(15);
            $factura->estado = 'NO PAGADA';
            $factura->muestra = 1;
            $factura->users_id = auth()->id();
            $factura->departamento_id = $departamentos->first();
            $factura->save();
    
            $total = 0;
    
            foreach ($muestras as $muestra) {
                if ($muestra->factura_id) {
                    session()->flash('danger', 'La muestra ' . $muestra->numero . ' ya tiene una factura asignada.');
                    return back();
                }
    
                $muestra->factura_id = $factura->id;
                $muestra->save();
                $total += $muestra->ensayos->sum('costo');
            }
    
            // USAMOS la misma lógica que en update(): selected_nomencladors + nomenclador_cantidades
            $factura->nomencladors()->detach(); // Por si viene repetido
    
            $selectedNomencladors = $request->input('selected_nomencladors', []);
            foreach ($selectedNomencladors as $nomencladorId) {
                $cantidad = $request->input('nomenclador_cantidades.' . $nomencladorId);
    
                if ($cantidad > 0) {
                    $nomenclador = Nomenclador::find($nomencladorId);
                    if ($nomenclador) {
                        $subtotal = $nomenclador->valor * $cantidad;
                        $factura->nomencladors()->attach($nomencladorId, [
                            'cantidad' => $cantidad,
                            'subtotal' => $subtotal
                        ]);
                        $total += $subtotal;
                    }
                }
            }
    
            $factura->total = $total;
            $factura->save();
    
            return back()->with('notification', 'Factura generada correctamente con ítems extras.');
        }
    } 

    public function condicion (Request $request, $id)
    {
        $muestra = Muestra::findOrFail($id);
        $muestra->condicion = $request->input('condicion');
        $muestra->save();
        $notification = 'Se ingreso la condición correctamente.';
        return back()->with(compact('notification'));
    }

    public function getNomencladorPorDepartamento()
    {
        $user = auth()->user();
    
        \Log::info("Entrando a getNomencladorPorDepartamento", ['user_id' => optional($user)->id]);
    
        if (!$user || !$user->departamento_id) {
            \Log::warning("Usuario no válido o sin departamento");
            return response()->json(['error' => 'Usuario sin departamento asignado'], 400);
        }
    
        $nomencladors = Nomenclador::where('departamento_id', $user->departamento_id)
                                  ->orderBy('descripcion')
                                  ->get(['id', 'descripcion']);
    
        \Log::info("Nomencladores cargados", ['count' => $nomencladors->count()]);
    
        return response()->json($nomencladors);
    }    

}
