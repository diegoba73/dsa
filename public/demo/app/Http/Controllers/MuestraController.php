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
        $id       = $request->get('id');
        $numero       = $request->get('numero');
        $tipo_muestra = $request->get('tipo_muestra');
        $muestra      = $request->get('muestra');
        $lugar      = $request->get('lugar_extraccion');
        $identificacion      = $request->get('identificacion');
        $lote      = $request->get('lote');
        $remitente      = $request->get('remitente');
        $departamento      = $request->get('departamento');
        $cargada      = $request->get('cargada');
        $pendiente      = $request->get('pendiente');
        $cromatografia = $request->get('cromatografia');
        $quimica = $request->get('quimica');
        $ensayo_biologico = $request->get('ensayo_biologico');
        $microbiologia = $request->get('microbiologia');
        $fechaEntradaInicio = $request->get('fecha_entrada_inicio');
        $fechaEntradaFinal = $request->get('fecha_entrada_final');
        $year = date('Y');
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8)&&(Auth::user()->departamento_id == 1)){

                    $muestras = Muestra::with('remitente')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->lugar($lugar)
                    ->identificacion($identificacion)
                    ->lote($lote)
                    ->departamento($departamento)
                    ->cargada($cargada)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->cromatografia($cromatografia)
                    ->quimica($quimica)
                    ->ensayo($ensayo_biologico)
                    ->microbiologia($microbiologia)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);

            } elseif ((Auth::user()->role_id == 13 || Auth::user()->role_id == 14)) {

                $muestras = Muestra::with('remitente')
                    ->whereHas('remitente', function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    })
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->lugar($lugar)
                    ->identificacion($identificacion)
                    ->lote($lote)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);                    
            } elseif ((Auth::user()->role_id == 1)&&(Auth::user()->departamento_id == 2)){

                        $muestras = Muestra::with('remitente')
                        ->where('muestras.departamento_id', '=', 2)
                        ->orderBy('muestras.id', 'DESC')
                        ->id($id)
                        ->numero($numero)
                        ->tipo($tipo_muestra)
                        ->muestra($muestra)
                        ->lugar($lugar)
                        ->identificacion($identificacion)
                        ->lote($lote)
                        ->departamento($departamento)
                        ->remite($remitente)
                        ->pendiente($pendiente)
                        ->cromatografia($cromatografia)
                        ->quimica($quimica)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                            return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                        })
                        ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                            return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                        })
                        ->paginate(50);

            } elseif (Auth::user()->id == 30) {

                $muestras = Muestra::with('remitente')
                ->orderBy('muestras.id', 'DESC')
                ->id($id)
                ->numero($numero)
                ->tipo($tipo_muestra)
                ->muestra($muestra)
                ->lugar($lugar)
                ->identificacion($identificacion)
                ->lote($lote)
                ->departamento($departamento)
                ->cargada($cargada)
                ->remite($remitente)
                ->pendiente($pendiente)
                ->cromatografia($cromatografia)
                ->quimica($quimica)
                ->ensayo($ensayo_biologico)
                ->microbiologia($microbiologia)
                ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                    return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                })
                ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                    return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                })
                ->paginate(50);

            } elseif ((Auth::user()->role_id == 1)&&(Auth::user()->departamento_id == 3)){

                        $muestras = Muestra::with('remitente')
                        ->where('muestras.departamento_id', '=', 3)
                        ->orderBy('muestras.id', 'DESC')
                        ->id($id)
                        ->numero($numero)
                        ->tipo($tipo_muestra)
                        ->muestra($muestra)
                        ->lugar($lugar)
                        ->identificacion($identificacion)
                        ->departamento($departamento)
                        ->remite($remitente)
                        ->pendiente($pendiente)
                        ->cromatografia($cromatografia)
                        ->quimica($quimica)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                            return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                        })
                        ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                            return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                        })
                        ->paginate(50);

            }  elseif ((Auth::user()->role_id == 12)&&(Auth::user()->departamento_id == 5)){

                        $muestras = Muestra::with('remitente')
                        ->where('muestras.tipo_prestacion', '=', 'ARANCELADO')
                        ->orderBy('muestras.id', 'DESC')
                        ->id($id)
                        ->numero($numero)
                        ->tipo($tipo_muestra)
                        ->muestra($muestra)
                        ->lugar($lugar)
                        ->identificacion($identificacion)
                        ->departamento($departamento)
                        ->remite($remitente)
                        ->pendiente($pendiente)
                        ->cromatografia($cromatografia)
                        ->quimica($quimica)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                            return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                        })
                        ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                            return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                        })
                        ->paginate(50);
                
        } elseif (Auth::user()->role_id == 3) {
                    $muestras = Muestra::with(['remitente', 'ensayos'])
                    ->whereHas('ensayos', function ($query) {
                        $query->where('tipo_ensayo', '=', 'Físico/Químico');
                    })
                    ->where('muestras.matriz_id', '=', '1')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);

                } elseif (Auth::user()->role_id == 4) {
                    $muestras = Muestra::with(['remitente', 'ensayos'])
                                ->whereHas('ensayos', function ($query) {
                                    $query->where('tipo_ensayo', '=', 'Físico/Químico');
                                })
                                ->where('muestras.matriz_id', '<>', '1')
                                ->orderBy('muestras.id', 'DESC')
                                ->id($id)
                                ->numero($numero)
                                ->tipo($tipo_muestra)
                                ->muestra($muestra)
                                ->departamento($departamento)
                                ->remite($remitente)
                                ->pendiente($pendiente)
                                ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                                    return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                                })
                                ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                                    return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                                })
                                ->paginate(50);

                } elseif (Auth::user()->role_id == 5) {
                    $muestras = Muestra::with(['remitente', 'ensayos'])
                                ->whereHas('ensayos', function ($query) {
                                    $query->where('tipo_ensayo', '=', 'Ensayo Biológico');
                                })
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);

        } elseif (Auth::user()->role_id == 6) {
                    $muestras = Muestra::with(['remitente', 'ensayos'])
                    ->whereHas('ensayos', function ($query) {
                        $query->where('tipo_ensayo', '=', 'Cromatografía');
                    })
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);
                
        } elseif (Auth::user()->role_id == 7) {
                    $muestras = Muestra::with(['remitente', 'ensayos'])
                    ->whereHas('ensayos', function ($query) {
                        $query->where('tipo_ensayo', '=', 'Microbiológico');
                    })
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);

        } elseif (Auth::user()->id == 6 || Auth::user()->id == 30 || Auth::user()->id == 2885) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.departamento_id', '=', 3)
                    ->orwhere('muestras.departamento_id', '=', 4)
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);                

        } else {
 
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.departamento_id', '=', (Auth::user()->departamento_id))
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->when($fechaEntradaInicio, function ($query, $fechaEntradaInicio) {
                        return $query->whereDate('fecha_entrada', '>=', $fechaEntradaInicio);
                    })
                    ->when($fechaEntradaFinal, function ($query, $fechaEntradaFinal) {
                        return $query->whereDate('fecha_entrada', '<=', $fechaEntradaFinal);
                    })
                    ->paginate(50);
        }

        $remitentes = Remitente::all();
        $matrizs = Matriz::all();
        $departamentos = Departamento::all();
        return view('lab.muestras.index')->with(compact('muestras', 'remitentes', 'matrizs', 'departamentos', 'pendiente', 'cargada', 'muestra', 'year')); // listado
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
        $muestra->condicion = "Sin/Conclusión";
        $muestra->save();
        $notification = 'La muestra fué colocada para su revisión nuevamente.';
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
        // actualizar Rechazo
        $muestra = Muestra::find($id);
        $muestra->criterio_rechazo = $request->input('criterio_rechazo');
        $muestra->aceptada = '0';
        $muestra->cargada = '0';
        $muestra->save(); // Insert rechazo
        $notification = 'La muestra fué RECHAZADA.';
        $url = Input::get('url');
        return redirect($url)->with(compact('notification'));

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
        // Ingresar Resultados
        $muestra = Muestra::find($id);
        $ensayoIds = DB::table('ensayo_muestra')->where('muestra_id', $id)->get();
        $fecha_inicio = Input::get('fecha_inicio[]');
        $fecha_fin = Input::get('fecha_fin[]');
        $resultados = Input::get('resultado');
        $muestra->fecha_inicio_analisis = $request->input('fecha_inicio_analisis');
        $muestra->fecha_fin_analisis = $request->input('fecha_fin_analisis');
        $muestra->cargada = 1;
        $muestra->observaciones = $request->input('observaciones');
        $muestra->save();
        $array = [];

            foreach ($ensayoIds as $key => $ensayoId) {
                $array[$ensayoId->ensayo_id] = ['resultado' => $resultados[$key]];
            }

        $muestra->ensayos()->sync($array);
        $url = Session::get('url');
        $notification = 'Se cargaron exitosamente los RESULTADOS de la Muestra.';
        return redirect()->route('lab_muestras_index', array('id' => $id))->with(compact('notification'));

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
            $remitente = Remitente::where('user_id', $user->id)->first(); // Buscar el remitente asociado al usuario
        } else {
            $remitente = null;
        }
        $provincias = Provincia::all();
        $localidads = Localidad::all();        
        $remitentes = Remitente::all();
        $tipomuestras = Tipomuestra::all();
        $matrizs = Matriz::all();
        $ensayos = Ensayo::orderBy('codigo')->get();
        $ensayosActivos = Ensayo::where('activo', 1)->get(); 
        return view('lab.muestras.create')->with(compact('remitente', 'remitentes', 'localidads', 'provincias', 'ensayosActivos', 'matrizs', 'tipomuestras'));  // formulario muestra
    }


    public function store(Request $request)
    {
        $message = [
            'matriz_id.required' => 'Se necesita la Matriz',
            'tipomuestra_id.required' => 'Se necesita el Tipo de Muestra',
            'muestra.required' => 'Se necesita describir la Muestra',
            'fecha_extraccion.required' => 'Se necesita la fecha de extracción'
            // Agrega los demás mensajes de error aquí
        ];
        
        $rules = [
            'matriz_id' => 'required',
            'tipomuestra_id' => 'required',
            'muestra' => 'required',
            'fecha_extraccion' => 'required',
        ];
        
        // Agrega las reglas adicionales si el rol es 13
        if ((auth()->user()->role_id === 13  || auth()->user()->role_id === 14)) {
            $message['entrada_hidden.required'] = 'Se necesita el dato del Tipo de Entrada';
            $message['tipo_prestacion_hidden.required'] = 'Se necesita el dato del Tipo de Prestación';
            $message['remitente_hidden.required'] = 'Se necesita el dato del Remitente';
            $message['solicitante_hidden.required'] = 'Se necesita el dato del Solicitante';
            
            $rules['entrada_hidden'] = 'required';
            $rules['tipo_prestacion_hidden'] = 'required';
            $rules['remitente_hidden'] = 'required';
            $rules['solicitante_hidden'] = 'required';
        } else {
            $message['entrada.required'] = 'Se necesita el dato del Tipo de Entrada';
            $message['tipo_prestacion.required'] = 'Se necesita el dato del Tipo de Prestación';
            $message['remitente.required'] = 'Se necesita el dato del Remitente';
            $message['solicitante.required'] = 'Se necesita el dato del Solicitante';
            
            $rules['entrada'] = 'required';
            $rules['tipo_prestacion'] = 'required';
            $rules['remitente'] = 'required';
            $rules['solicitante'] = 'required';
        }
        
        // Agrega las reglas comunes para todos los roles

        $rules['localidad_id'] = 'required';
        $rules['provincia_id'] = 'required';
        
        $this->validate($request, $rules, $message);



    $ingresos = $request->input('ingresos');
    
    for($i=1;$i<=$ingresos;$i++) {
         //dd($request->all());
        // registrar una muestra
        $muestra = new Muestra();
        $ultimo_registro = Muestra::orderBy('id', 'desc')->first();
        $ultimo_ano = Carbon::parse($ultimo_registro->fecha_entrada)->year;
        $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 

        // $muestra->departamento_id = $this->auth->user()->departamento_id;
        if ((auth()->user()->role_id === 13 || auth()->user()->role_id === 14)) {
            $muestra->entrada = $request->input('entrada_hidden');
            $muestra->tipo_prestacion = $request->input('tipo_prestacion_hidden');
            $muestra->remitente_id = $request->input('remitente_hidden');
            $muestra->solicitante = $request->input('solicitante_hidden');
        } else {
            $muestra->entrada = $request->input('entrada');
            $muestra->tipo_prestacion = $request->input('tipo_prestacion');
            $muestra->remitente_id = $request->input('remitente');
            $muestra->solicitante = $request->input('solicitante');
        }
        
        $muestra->numero = $numero_siguiente;
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
/*         $muestra->microbiologia = $request->input('microbiologia');
        $muestra->quimica = $request->input('quimica');
        $muestra->cromatografia = $request->input('cromatografia');
        $muestra->ensayo_biologico = $request->input('ensayo_biologico'); */
        $muestra->aceptada = $request->input('aceptada');
        $muestra->condicion = 'Sin/Conclusión';
        $muestra->cargada = 0;
        $muestra->user_id = $this->auth->user()->id;
        // Agregar ensayos
        $ensayos = Input::get('ensayo_id');

        if (in_array(285, $ensayos) || in_array(286, $ensayos) || in_array(251, $ensayos)) {
            // Si se solicita alguno de los ensayos mencionados, asigna el valor 2 a departamento_id
            $request->merge(['departamento_id' => 2]);
        }
        
        $muestra->departamento_id = $request->input('departamento_id'); // Asigna el valor antes de sincronizar
        
        $muestra->save(); // Insert muestra

        // Sincroniza los ensayos
        $muestra->ensayos()->sync($ensayos);
    }  
    
    if ($ingresos == 1) {
        $notification = 'La muestra fué INGRESADA correctamente.';
        return redirect('/lab/muestras/index')->with(compact('notification'));
    }
    else {
        $notification = 'Las muestras fueron INGRESADAS correctamente.';
        return redirect('/lab/muestras/index')->with(compact('notification'));
    }


    }

    public function edit($id)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $remitente = null;
        
        if (($user->role_id === 13 || $user->role_id === 14)) {
            $remitente = Remitente::where('user_id', $user->id)->first(); // Buscar el remitente asociado al usuario
        }
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 12 || Auth::user()->role_id == 8) && (Auth::user()->departamento_id == 1 || Auth::user()->id == 6 || Auth::user()->id == 30 || Auth::user()->id == 2885)){
        $muestra = Muestra::findOrFail($id);
        } else {
        $muestra = Muestra::where('muestras.departamento_id', '=', auth()->user()->departamento_id)->findOrFail($id);
        }
        $localidads = Localidad::all();
        $provincias = Provincia::all();         
        $remitentes = Remitente::all();
        $matrizs = Matriz::all();
        $tipomuestras = Tipomuestra::all();
        $matriz = Matriz::pluck('matriz');
        $ensayos = Ensayo::orderBy('codigo')->where('matriz_id', $muestra->matriz_id)->get();
        $selects = DB::table('ensayo_muestra')->where('muestra_id', $id)->get();
        $url = redirect()->getUrlGenerator()->previous();
        return view('lab.muestras.edit')->with(compact('muestra', 'remitente', 'remitentes', 'localidads', 'provincias', 'matrizs', 'matriz', 'tipomuestras', 'ensayos', 'selects', 'url', 'user'));  // formulario edición muestra
    }


    public function update(Request $request, $id)
    {

        $message = [
            'matriz_id.required' => 'Se necesita la Matriz',
            'tipomuestra_id.required' => 'Se necesita el Tipo de Muestra',
            'muestra.required' => 'Se necesita describir la Muestra',
            'entrada_hidden.required' => 'Se necesita el dato del Tipo de Entrada',
            'tipo_prestacion_hidden.required' => 'Se necesita el dato del Tipo de Prestación',
            'remitente_hidden.required' => 'Se necesita el dato del Remitente',
            'localidad_id.required' => 'Se necesita la Localidad',
            'provincia_id.required' => 'Se necesita la Provincia',
            // Resto de los mensajes personalizados
        ];
        
        $rules = [
            'matriz_id' => 'required',
            'tipomuestra_id' => 'required',
            'muestra' => 'required',
            'entrada_hidden' => 'required',
            'tipo_prestacion_hidden' => 'required',
            'remitente_hidden' => 'required',
            'localidad_id' => 'required',
            'provincia_id' => 'required',
            // Resto de las reglas de validación
        
/*             'microbiologia' => 'required_without_all:cromatografia,quimica,ensayo_biologico',
            'cromatografia' => 'required_without_all:microbiologia,quimica,ensayo_biologico',
            'quimica' => 'required_without_all:microbiologia,cromatografia,ensayo_biologico',
            'ensayo_biologico' => 'required_without_all:microbiologia,cromatografia,quimica', */
        ];

        $this->validate($request, $rules, $message);
        
        // actualizar muestra
        $user = auth()->user(); // Obtener el usuario autenticado
        $muestra = Muestra::find($id);
        if (($user->role_id === 13 || $user->role_id === 14)) {
            // Obtén los valores originales de los campos ocultos
            $entradaOriginal = $request->input('entrada_hidden');
            $tipoPrestacionOriginal = $request->input('tipo_prestacion_hidden');
            $remitenteOriginalId = $request->input('remitente_hidden');
            $solicitanteOriginal = $request->input('solicitante_hidden');
            
            $muestra->entrada = $entradaOriginal;
            $muestra->tipo_prestacion = $tipoPrestacionOriginal;
            $muestra->remitente_id = $remitenteOriginalId;
            $muestra->solicitante = $solicitanteOriginal;
        } else {
            $muestra->entrada = $request->input('entrada');
            $muestra->tipo_prestacion = $request->input('tipo_prestacion');
            $muestra->remitente_id = $request->input('remitente');
            $muestra->solicitante = $request->input('solicitante');
        }      
        $muestra->departamento_id = $request->input('departamento_id');
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
        $muestra->microbiologia = $request->input('microbiologia');
        $muestra->quimica = $request->input('quimica');
        $muestra->cromatografia = $request->input('cromatografia');
        $muestra->ensayo_biologico = $request->input('ensayo_biologico');
        $muestra->criterio_rechazo = $request->input('criterio_rechazo');
        $muestra->user_id = $this->auth->user()->id;
        $muestra->save(); // Insert muestra
        // Agregar ensayos
        $pedido = Input::get('ensayo_id');
        $url = Session::get('url');
        $muestra->ensayos()->sync($pedido);
        $notification = 'La muestra fué ACTUALIZADA correctamente.';
        return redirect()->route('lab_muestras_index')->with(compact('notification'));

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
        
                // Realiza la acción que deseas hacer en cada modelo seleccionado
                $muestra->update(['revisada' => true]);
            }
                
            $notification = 'Las muestras fueron REVISADAS correctamente.';
            return back()->with(compact('notification'));

        } elseif ($action === 'generarFactura') {

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
        
            $total = 0;
            $fecha_emision = now();
            $fecha_vencimiento = now()->addDays(15);
        
            // Crear factura
            $factura = new Factura();
            $factura->remitentes_id = $muestras->pluck('remitente.id')->unique()->first();
            $factura->fecha_emision = $fecha_emision;
            $factura->fecha_vencimiento = $fecha_vencimiento;
            $factura->estado = 'NO PAGADA';
            $factura->muestra = 1;
            $factura->users_id = $this->auth->user()->id;
            $factura->departamentos_id = $this->auth->user()->departamento_id;
            $factura->save();
        
            // Asignar factura a las muestras seleccionadas
            foreach ($muestras as $muestra) {
                // Validar que la muestra no tenga ya una factura asignada
                if ($muestra->factura_id) {
                    session()->flash('danger', 'La muestra ' . $muestra->numero . ' ya tiene una factura asignada.');
                    return back();
                }
        
                $muestra->factura_id = $factura->id;
                $muestra->save();
        
                // Calcular el total de los ensayos de la muestra
                $total += $muestra->ensayos->sum('costo');
            }
        
            $factura->total = $total;
            $factura->save();
        
            $notification = 'Las muestras fueron FACTURADAS correctamente.';
            return back()->with(compact('notification'));
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

}

