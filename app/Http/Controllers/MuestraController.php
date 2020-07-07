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
use Carbon\Carbon;
use \PDF;
use Session;

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
        $remitente      = $request->get('remitente');
        $departamento      = $request->get('departamento');
        $pendiente      = $request->get('pendiente');
        $cromatografia = $request->get('cromatografia');
        $quimica = $request->get('quimica');
        $ensayo_biologico = $request->get('ensayo_biologico');
        $microbiologia = $request->get('microbiologia');
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 8)&&(Auth::user()->departamento_id == 1)){

                    $muestras = Muestra::with('remitente')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->lugar($lugar)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->cromatografia($cromatografia)
                    ->quimica($quimica)
                    ->ensayo($ensayo_biologico)
                    ->microbiologia($microbiologia)
                    ->paginate(20);

            }  elseif ((Auth::user()->role_id == 12)&&(Auth::user()->departamento_id == 5)){

                        $muestras = Muestra::with('remitente')
                        ->where('muestras.tipo_prestacion', '=', 'ARANCELADO')
                        ->orderBy('muestras.id', 'DESC')
                        ->id($id)
                        ->numero($numero)
                        ->tipo($tipo_muestra)
                        ->muestra($muestra)
                        ->lugar($lugar)
                        ->departamento($departamento)
                        ->remite($remitente)
                        ->pendiente($pendiente)
                        ->cromatografia($cromatografia)
                        ->quimica($quimica)
                        ->ensayo($ensayo_biologico)
                        ->microbiologia($microbiologia)
                        ->paginate(20);
                
        } elseif (Auth::user()->role_id == 3) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.quimica', '=', 1)
                    ->where('muestras.matriz_id', '=', '1')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->paginate(20);

        } elseif (Auth::user()->role_id == 4) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.quimica', '=', 1)
                    ->where('muestras.matriz_id', '<>', '1')
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->paginate(20);

        } elseif (Auth::user()->role_id == 5) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.ensayo_biologico', '=', 1)
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->paginate(20);

        } elseif (Auth::user()->role_id == 6) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.cromatografia', '=', 1)
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->paginate(20);
                
        } elseif (Auth::user()->role_id == 7) {
                    $muestras = Muestra::with('remitente')
                    ->where('muestras.microbiologia', '=', 1)
                    ->orderBy('muestras.id', 'DESC')
                    ->id($id)
                    ->numero($numero)
                    ->tipo($tipo_muestra)
                    ->muestra($muestra)
                    ->departamento($departamento)
                    ->remite($remitente)
                    ->pendiente($pendiente)
                    ->paginate(20);

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
                    ->paginate(20);
        }

        $remitentes = Remitente::all();
        $matrizs = Matriz::all();
        $departamentos = Departamento::all();
        $dl = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 1)->where('cargada', 0)->get();
        $dl_m = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 1)->where('cargada', 0)->where('microbiologia', 1)->get();
        $dl_q = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 1)->where('cargada', 0)->where('quimica', 1)->get();
        $dl_c = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 1)->where('cargada', 0)->where('cromatografia', 1)->get();
        $dl_eb = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 1)->where('cargada', 0)->where('ensayo_biologico', 1)->get();
        $dl_t = DB::table('muestras')->where('departamento_id', 1)->whereNotNull('aceptada');
        $dl_r = DB::table('muestras')->where('departamento_id', 1)->where('aceptada', 0);
        $db = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 1)->where('cargada', 0)->get();
        $db_m = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 1)->where('cargada', 0)->where('microbiologia', 1)->get();
        $db_q = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 1)->where('cargada', 0)->where('quimica', 1)->get();
        $db_c = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 1)->where('cargada', 0)->where('cromatografia', 1)->get();
        $db_eb = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 1)->where('cargada', 0)->where('ensayo_biologico', 1)->get();
        $db_t = DB::table('muestras')->where('departamento_id', 2)->whereNotNull('aceptada');
        $db_r = DB::table('muestras')->where('departamento_id', 2)->where('aceptada', 0);
        $dsb = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 1)->where('cargada', 0)->get();
        $dsb_m = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 1)->where('cargada', 0)->where('microbiologia', 1)->get();
        $dsb_q = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 1)->where('cargada', 0)->where('quimica', 1)->get();
        $dsb_c = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 1)->where('cargada', 0)->where('cromatografia', 1)->get();
        $dsb_eb = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 1)->where('cargada', 0)->where('ensayo_biologico', 1)->get();
        $dsb_t = DB::table('muestras')->where('departamento_id', 3)->whereNotNull('aceptada');
        $dsb_r = DB::table('muestras')->where('departamento_id', 3)->where('aceptada', 0);
        $dso = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 1)->where('cargada', 0)->get();
        $dso_m = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 1)->where('cargada', 0)->where('microbiologia', 1)->get();
        $dso_q = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 1)->where('cargada', 0)->where('quimica', 1)->get();
        $dso_c = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 1)->where('cargada', 0)->where('cromatografia', 1)->get();
        $dso_eb = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 1)->where('cargada', 0)->where('ensayo_biologico', 1)->get();
        $dso_t = DB::table('muestras')->where('departamento_id', 4)->whereNotNull('aceptada');
        $dso_r = DB::table('muestras')->where('departamento_id', 4)->where('aceptada', 0);
        return view('lab.muestras.index')->with(compact('muestras', 'dl', 'dsb', 'dso', 'db', 'dl_t', 'dsb_t', 'dso_t', 'db_t', 'dl_r', 'dsb_r', 'dso_r', 'db_r', 'dl_m', 'db_m', 'dsb_m', 'dso_m', 'dl_q', 'db_q', 'dsb_q', 'dso_q', 'dl_c', 'db_c', 'dsb_c', 'dso_c', 'dl_eb', 'db_eb', 'dsb_eb', 'dso_eb', 'remitentes', 'matrizs', 'departamentos', 'pendiente', 'muestra')); // listado
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
        $muestra->revisada = '0';
        $muestra->save();
        $notification = 'La muestra fué colocada para su revisación nuevamente.';
        return back()->with(compact('notification'));
    }

    public function show($id)
    {
        $muestra = Muestra::find($id);
        $departamento = Departamento::all();
        $provincia = Provincia::all();
        $localidad = Localidad::all();        
        $remitente = Remitente::all();
        $matriz = Matriz::all();
        $tipomuestra = Tipomuestra::all();
        $ensayos = Ensayo::orderBy('id', 'ASC')->get();
        return view('lab.muestras.show')->with(compact('muestra', 'tipomuestra', 'remitente', 'matriz', 'departamento', 'provincia', 'localidad', 'ensayos')); // listado
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

        $provincias = Provincia::all();
        $localidads = Localidad::all();        
        $remitentes = Remitente::all();
        $tipomuestras = Tipomuestra::all();
        $matrizs = Matriz::all();
        $ensayos = Ensayo::orderBy('codigo')->get();

        return view('lab.muestras.create')->with(compact('remitentes', 'localidads', 'provincias', 'ensayos', 'matrizs', 'tipomuestras'));  // formulario muestra
    }


    public function store(Request $request)
    {
        $message = [
            'matriz_id.required' => 'Se necesita la Matriz',
            'tipomuestra_id.required' => 'Se necesita el Tipo de Muestra',
            'muestra.required' => 'Se necesita describir la Muestra',
            'entrada.required' => 'Se necesita el dato del Tipo de Entrada',
            'tipo_prestacion.required' => 'Se necesita el dato del Tipo de Prestación',
            'remitente.required' => 'Se necesita el dato del Remitente',
            'solicitante.required' => 'Se necesita el dato del Solicitante',
            'localidad_id.required' => 'Se necesita la Localidad',
            'provincia_id.required' => 'Se necesita la Provincia',
            'required_without_all' => 'Se necesita seleccionar al menos un Área'

        ];
        
        $rules = [
            'matriz_id' => 'required',
            'tipomuestra_id' => 'required',
            'muestra' => 'required',
            'entrada' => 'required',
            'tipo_prestacion' => 'required',
            'remitente' => 'required',
            'solicitante' => 'required',
            'localidad_id' => 'required',
            'provincia_id' => 'required',
            'microbiologia' => 'required_without_all:cromatografia,quimica,ensayo_biologico',
            'cromatografia' => 'required_without_all:microbiologia,quimica,ensayo_biologico',
            'quimica' => 'required_without_all:microbiologia,cromatografia,ensayo_biologico',
            'ensayo_biologico' => 'required_without_all:microbiologia,cromatografia,quimica',
        ];

        $this->validate($request, $rules, $message);



    $ingresos = $request->input('ingresos');
    for($i=1;$i<=$ingresos;$i++) {
         //dd($request->all());
        // registrar una muestra
        $muestra = new Muestra();
        $registros_tabla = Muestra::count();
                if ($registros_tabla == 0){
                    $numero_siguiente = 1; 
                }
                else {
                $ultimo_registro = Muestra::orderBy('id', 'desc')->first();
                $ultimo_ano = Carbon::parse($ultimo_registro->fecha_entrada)->year;
                $ano_actual = Carbon::now()->year;
                
                if ( $ultimo_ano == $ano_actual)
                { $numero_siguiente = $ultimo_registro->numero+1;
                } 
                else {
                $numero_siguiente = 1; } 
                }
        $muestra->departamento_id = $this->auth->user()->departamento_id;
        $muestra->numero = $numero_siguiente;
        $muestra->matriz_id = $request->input('matriz_id');
        $muestra->tipomuestra_id = $request->input('tipomuestra_id');
        $muestra->muestra = $request->input('muestra');
        $muestra->nro_cert_cadena_custodia = $request->input('cadena_custodia');
        $muestra->identificacion = $request->input('identificacion');
        $muestra->entrada = $request->input('entrada');
        $muestra->tipo_prestacion = $request->input('tipo_prestacion');
        $muestra->fecha_entrada = $request->input('fecha_entrada');
        $muestra->remitente_id = $request->input('remitente');
        $muestra->solicitante = $request->input('solicitante');
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
        $muestra->aceptada = $request->input('aceptada');
        $muestra->condicion = 'Sin/Conclusión';
        $muestra->cargada = 0;
        $muestra->user_id = $this->auth->user()->id;
        $muestra->save(); // Insert muestra
        // Agregar ensayos
        $ensayos = Input::get('ensayo_id');
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
        if ((Auth::user()->role_id == 1 || Auth::user()->role_id == 12 || Auth::user()->role_id == 8)&&(Auth::user()->departamento_id == 1)){
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
        return view('lab.muestras.edit')->with(compact('muestra','remitentes', 'localidads', 'provincias', 'matrizs', 'matriz', 'tipomuestras', 'ensayos', 'selects', 'url'));  // formulario edición muestra
    }


    public function update(Request $request, $id)
    {

        $message = [
            'matriz_id.required' => 'Se necesita la Matriz',
            'tipomuestra_id.required' => 'Se necesita el Tipo de Muestra',
            'muestra.required' => 'Se necesita describir la Muestra',
            'entrada.required' => 'Se necesita el dato del Tipo de Entrada',
            'tipo_prestacion.required' => 'Se necesita el dato del Tipo de Prestación',
            'remitente.required' => 'Se necesita el dato del Remitente',
            'solicitante.required' => 'Se necesita el dato del Solicitante',
            'localidad_id.required' => 'Se necesita la Localidad',
            'provincia_id.required' => 'Se necesita la Provincia',
            'required_without_all' => 'Se necesita seleccionar al menos un Área'

        ];
        
        $rules = [
            'matriz_id' => 'required',
            'tipomuestra_id' => 'required',
            'muestra' => 'required',
            'entrada' => 'required',
            'tipo_prestacion' => 'required',
            'remitente' => 'required',
            'solicitante' => 'required',
            'localidad_id' => 'required',
            'provincia_id' => 'required',
            'microbiologia' => 'required_without_all:cromatografia,quimica,ensayo_biologico',
            'cromatografia' => 'required_without_all:microbiologia,quimica,ensayo_biologico',
            'quimica' => 'required_without_all:microbiologia,cromatografia,ensayo_biologico',
            'ensayo_biologico' => 'required_without_all:microbiologia,cromatografia,quimica',
        ];

        $this->validate($request, $rules, $message);
        
        // actualizar muestra
        $muestra = Muestra::find($id);
        $muestra->matriz_id = $request->input('matriz_id');
        $muestra->tipomuestra_id = $request->input('tipomuestra_id');
        $muestra->muestra = $request->input('muestra');
        $muestra->nro_cert_cadena_custodia = $request->input('cadena_custodia');
        $muestra->identificacion = $request->input('identificacion');
        $muestra->entrada = $request->input('entrada');
        $muestra->tipo_prestacion = $request->input('tipo_prestacion');
        $muestra->fecha_entrada = $request->input('fecha_entrada');
        $muestra->remitente_id = $request->input('remitente');
        $muestra->solicitante = $request->input('solicitante');
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
        $muestra->aceptada = $request->input('aceptada');
        $muestra->criterio_rechazo = $request->input('criterio_rechazo');
        $muestra->condicion = $request->input('condicion');
        $muestra->user_id = $this->auth->user()->id;
        $muestra->save(); // Insert muestra
        // Agregar ensayos
        $pedido = Input::get('ensayo_id');
        $url = Session::get('url');
        $muestra->ensayos()->sync($pedido);
        $notification = 'La muestra fué ACTUALIZADA correctamente.';
        return redirect()->route('lab_muestras_index')->with(compact('notification'));

    }

    public function exportDbExcel()
    {
        return Excel::download(new DbExport, 'consulta-muestras.xls');
    }

    public function exportDsbExcel()
    {
        return Excel::download(new DsbExport, 'consulta-muestras.xls');
    }

    public function exportDlExcel()
    {
        return Excel::download(new DlExport, 'consulta-muestras.xls');
    }

    public function exportDsoExcel()
    {
        return Excel::download(new DsoExport, 'consulta-muestras.xls');
    }
}

