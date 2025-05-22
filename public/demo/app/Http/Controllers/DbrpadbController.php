<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        $idEmpresa = null;
        
        if ($user->role_id == 15) {
            if ($user->rpadb()->exists()) {
                $idEmpresa = $user->empresa->first()->id;
            }
    
            if ($idEmpresa !== null) {
                $numero = $request->get('numero');
                $denominacion = $request->get('denominacion');
                $marca = $request->get('marca');
                $rpadbs = Dbrpadb::where('dbempresa_id', $idEmpresa)
                    ->numero($numero)
                    ->denominacion($denominacion)
                    ->marca($marca)
                    ->orderBy('numero', 'DESC')
                    ->paginate(20);
            } else {
                // Si el usuario tiene el role_id 15 pero no tiene empresas asociadas
                $rpadbs = Dbrpadb::where('id', 0)->paginate(20);

            }
        } else {
            // Si el role_id no es 15, mostrar todos los registros paginados
            $numero = $request->get('numero');
            $denominacion = $request->get('denominacion');
            $marca = $request->get('marca');
            $rpadbs = Dbrpadb::orderBy('numero', 'DESC')
                ->numero($numero)
                ->denominacion($denominacion)
                ->marca($marca)
                ->paginate(20);
        }
    
        return view('db.rpadb.index')->with(compact('rpadbs')); // Listado rpadbs
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rpadb = Dbrpadb::all();
        $user = Auth::user();
        $dbredbIds = $user->redb()->pluck('id')->toArray();
        $dbrubros = Dbrubro::all();
        $dbcategorias = Dbcategoria::all();
        $redbs = Dbredb::whereIn('id', $dbredbIds)->get();
        
        // Obtener los datos relacionados de la tabla pivotcat con la tabla dbrubro usando JOIN
        $pivotcat = DB::table('dbredb_dbrubro')
        ->whereIn('dbredb_id', $dbredbIds)
        ->leftJoin('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
        ->leftJoin('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
        ->leftJoin('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
        ->select(
            'dbredb_dbrubro.*',
            'dbcategorias.categoria as categoria_nombre',
            'dbrubros.rubro as rubro_nombre',
            'dbredbs.numero as redb_numero'
        )
        ->get();
        return view('db.rpadb.create')->with(compact('rpadb', 'redbs', 'dbrubros', 'pivotcat', 'dbcategorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rpadb = new Dbrpadb();
        $rpadb->expediente = $request->input('expediente');
        $rpadb->denominacion = $request->input('denominacion');
        $rpadb->nombre_fantasia = $request->input('nombre_fantasia');
        $rpadb->marca = $request->input('marca');
        $rpadb->envase = $request->input('envase');
        $rpadb->lote = $request->input('lote');
        $rpadb->fecha_envasado = $request->input('fecha_envasado');
        $rpadb->fecha_vencimiento = $request->input('fecha_vencimiento');
        $rpadb->fecha_envasado = $request->input('fecha_envasado');
        $rpadb->contenido_neto = $request->input('contenido_neto');
        $rpadb->peso_escurrido = $request->input('peso_escurrido');
        $rpadb->unidad_venta = $request->input('unidad_venta');
        $rpadb->lapso_aptitud = $request->input('lapso_aptitud');
        $rpadb->fecha_inscripcion = $request->input('fecha_inscripcion');
        $rpadb->articulo_caa = $request->input('articulo_caa');
        $rpadb->fecha_inscripcion = $request->input('fecha_inscripcion');
        $fechaReinscripcion = Carbon::now()->addYears(5)->toDateString();
        $rpadb->fecha_reinscripcion = $fechaReinscripcion;

        $selectedItemId = $request->input('selected_item_id');
        
        $selectedItem = DB::table('dbredb_dbrubro')
            ->where('id', $selectedItemId)
            ->first();
        // Obtener los valores específicos
        $dbredb_dbrubro_id = $selectedItem->id;
        $dbredb_id = $selectedItem->dbredb_id;
        $rpadb->dbredb_dbrubro_id = $dbredb_dbrubro_id;
        $rpadb->dbredb_id = $dbredb_id;
        // Realizar acciones con los valores obtenidos (guardarlos en la base de datos, etc.)
        $user = Auth::user();
        $idEmpresa = $user->empresa->first()->id;
        $rpadb->dbempresa_id = $idEmpresa;
        $rpadb->user_id = $user->id;
        $idRpadb = $rpadb->id;
     // Sube el archivo de ingredientes si está presente
    if ($request->hasFile('ingredientes')) {
        $ingArchivo = $request->file('ingredientes');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_ingredientes' . $ingArchivo->getClientOriginalExtension();
        $rutaING = Storage::disk('local')->putFileAs($carpeta, $ingArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_ingredientes = $rutaING;
    }

     // Sube el archivo de especificaciones si está presente
    if ($request->hasFile('especificaciones')) {
        $espArchivo = $request->file('especificaciones');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_especificaciones' . $espArchivo->getClientOriginalExtension();
        $rutaESP = Storage::disk('local')->putFileAs($carpeta, $espArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_especificaciones = $rutaESP;
    }
 
     // Sube el archivo de monografia si está presente
    if ($request->hasFile('monografia')) {
        $monoArchivo = $request->file('monografia');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_monografia' . $monoArchivo->getClientOriginalExtension();
        $rutaMONO = Storage::disk('local')->putFileAs($carpeta, $monoArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_especificaciones = $rutaMONO;
    }

     // Sube el archivo de rotulo si está presente
    if ($request->hasFile('rotulo')) {
        $rotuloArchivo = $request->file('rotulo');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_rotulo' . $rotuloArchivo->getClientOriginalExtension();
        $rutaRotulo = Storage::disk('local')->putFileAs($carpeta, $rotuloArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_rotulo = $rutaRotulo;
    }
     // Sube el archivo de informacion si está presente
    if ($request->hasFile('informacion')) {
        $informacionArchivo = $request->file('informacion');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_informacion' . $rotuloArchivo->getClientOriginalExtension();
        $rutaInformacion = Storage::disk('local')->putFileAs($carpeta, $informacionArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_informacion = $rutaInformacion;
    }

     // Sube el archivo de pago si está presente
    if ($request->hasFile('pago')) {
        $pagoArchivo = $request->file('pago');
        $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_pago' . $pagoArchivo->getClientOriginalExtension();
        $rutaPago = Storage::disk('local')->putFileAs($carpeta, $pagoArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $rpadb->ruta_pago = $rutaPago;
    }

        $rpadb->save(); // Insertar registro
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha_inicio = Carbon::now();
        $ultimoIngresado = Dbrpadb::latest()->where('user_id', Auth::id())->first();
        $dbhistorial->area = 'BROMATOLOGIA';
        $dbhistorial->motivo = 'INSCRIPCION PRODUCTO - ' . $ultimoIngresado->denominacion;
        $dbhistorial->estado = 'PENDIENTE';
        $dbhistorial->user_id = Auth::id();
        $dbhistorial->dbempresa_id = $idEmpresa;
        $dbhistorial->dbrpadb_id = $ultimoIngresado->id; // Supongo que el campo 'id' es la clave primaria de Dbredb

        $dbhistorial->save();
        $notification = 'El registro fué INGRESADO correctamente.';
        return redirect('/rpadb/index')->with(compact('notification'));
      
    
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
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    $rpadb = Dbrpadb::findOrFail($id);
    $user = Auth::user();
    $dbredbIds = $user->redb()->pluck('id')->toArray();
    $dbrubros = Dbrubro::all();
    $dbcategorias = Dbcategoria::all();
    $userProducerRole = $user->role_id === 15; // Reemplaza con el rol del usuario "productor"
    $historial = Dbhistorial::where('dbrpadb_id', $id)->latest()->first();
    if ($user->role_id === 15) {
        // Si el usuario tiene el rol 15, obtener los Dbredb asociados al usuario
        $dbredbIds = $user->redb()->pluck('id')->toArray();
        $redbs = Dbredb::whereIn('id', $dbredbIds)->get();
    } else {
        // Si el usuario no tiene el rol 15, obtener el Dbempresa_id de $rpadb y sus Dbredb asociados
        $dbempresaId = $rpadb->dbempresa_id;
        $redbs = Dbredb::where('dbempresa_id', $dbempresaId)->get();
    }
    // Verificar si el usuario tiene el rol "productor"
    if ($userProducerRole) {
        // Obtener los IDs de los Dbredb asociados al usuario "productor"
        $dbredbIdsProducer = Dbredb::where('user_id', $user->id)->pluck('id')->toArray();

        // Obtener los datos relacionados de la tabla pivotcat con la tabla dbrubro usando JOIN
        $pivotcat = DB::table('dbredb_dbrubro')
                ->whereIn('dbredb_id', $dbredbIdsProducer)
                ->leftJoin('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
                ->leftJoin('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
                ->leftJoin('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
                ->select(
                    'dbredb_dbrubro.*',
                    'dbcategorias.categoria as categoria_nombre',
                    'dbrubros.rubro as rubro_nombre',
                    'dbredbs.numero as redb_numero'
                )
                ->get();
        } else {
            // Obtener el ID de la empresa asociada al usuario


            // Obtener los IDs de los dbredbs asociados a la empresa
            $dbredbIds = $redbs->pluck('id')->toArray();


            // Obtener los datos relacionados de la tabla pivotcat con la tabla dbrubro usando JOIN
            $pivotcat = DB::table('dbredb_dbrubro')
                ->whereIn('dbredb_id', $dbredbIds)
                ->leftJoin('dbrubros', 'dbredb_dbrubro.dbrubro_id', '=', 'dbrubros.id')
                ->leftJoin('dbcategorias', 'dbredb_dbrubro.dbcategoria_id', '=', 'dbcategorias.id')
                ->leftJoin('dbredbs', 'dbredb_dbrubro.dbredb_id', '=', 'dbredbs.id')
                ->select(
                    'dbredb_dbrubro.*',
                    'dbcategorias.categoria as categoria_nombre',
                    'dbrubros.rubro as rubro_nombre',
                    'dbredbs.numero as redb_numero'
                )
                ->get();
        }


    return view('db.rpadb.edit')->with(compact('rpadb', 'redbs', 'dbrubros', 'pivotcat', 'dbcategorias', 'historial'));
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
        $rpadb = Dbrpadb::findOrFail($id);
        $rpadb->expediente = $request->input('expediente');


        if ($request->filled('expediente')) {
            // Solo ejecuta este bloque si el campo 'expediente' tiene datos
            
            // Obtener el valor máximo de la columna 'numero'
            $maxNumero = Dbrpadb::max('numero');
        
            // Calcular el siguiente número, asegurándose de que sea al menos 1
            $rpadb->numero = ($maxNumero !== null && $maxNumero > 0) ? $maxNumero + 1 : 1;
        }

        $rpadb->denominacion = $request->input('denominacion');
        $rpadb->nombre_fantasia = $request->input('nombre_fantasia');
        $rpadb->marca = $request->input('marca');
        $rpadb->envase = $request->input('envase');
        $rpadb->lote = $request->input('lote');
        $rpadb->fecha_envasado = $request->input('fecha_envasado');
        $rpadb->fecha_vencimiento = $request->input('fecha_vencimiento');
        $rpadb->fecha_envasado = $request->input('fecha_envasado');
        $rpadb->contenido_neto = $request->input('contenido_neto');
        $rpadb->peso_escurrido = $request->input('peso_escurrido');
        $rpadb->unidad_venta = $request->input('unidad_venta');
        $rpadb->lapso_aptitud = $request->input('lapso_aptitud');
        $rpadb->fecha_inscripcion = $request->input('fecha_inscripcion');
        $rpadb->articulo_caa = $request->input('articulo_caa');
        $rpadb->fecha_inscripcion = $request->input('fecha_inscripcion');
        $fechaReinscripcion = Carbon::now()->addYears(5)->toDateString();
        $rpadb->fecha_reinscripcion = $fechaReinscripcion;

        $selectedItemId = $request->input('selected_item_id');

        // Verificar si el ID seleccionado no es nulo
        if ($selectedItemId !== null) {
            $selectedItem = DB::table('dbredb_dbrubro')
                ->where('id', $selectedItemId)
                ->first();
        
            // Verificar si el resultado no es nulo
            if ($selectedItem) {
                // Obtener los valores específicos
                $dbredb_dbrubro_id = $selectedItem->id;
                $dbredb_id = $selectedItem->dbredb_id;
        
                // Asignar valores al modelo $rpadb
                $rpadb->dbredb_dbrubro_id = $dbredb_dbrubro_id;
                $rpadb->dbredb_id = $dbredb_id;
        
                // Puedes agregar más acciones aquí si es necesario
        
                // Guardar el modelo en la base de datos
                $rpadb->save();
            }
            // Si $selectedItem es nulo, no se realiza ninguna acción.
        }

        if (Auth::user()->role_id === 15) {
            // Realizar acciones con los valores obtenidos (guardarlos en la base de datos, etc.)
            $user = Auth::user();
            $idEmpresa = $user->empresa->first()->id;
            $rpadb->dbempresa_id = $idEmpresa;
            $rpadb->user_id = $user->id;
            $idRpadb = $rpadb->id;
            // Sube el archivo de analisis si está presente
            if ($request->hasFile('analisis')) {
                $ingArchivo = $request->file('analisis');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_analisis' . $ingArchivo->getClientOriginalExtension();
                $rutaANALISIS = Storage::disk('local')->putFileAs($carpeta, $ingArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_analisis = $rutaANALISIS;
            }
            // Sube el archivo de ingredientes si está presente
            if ($request->hasFile('ingredientes')) {
                $ingArchivo = $request->file('ingredientes');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_ingredientes' . $ingArchivo->getClientOriginalExtension();
                $rutaING = Storage::disk('local')->putFileAs($carpeta, $ingArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_ingredientes = $rutaING;
            }

            // Sube el archivo de especificaciones si está presente
            if ($request->hasFile('especificaciones')) {
                $espArchivo = $request->file('especificaciones');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_especificaciones' . $espArchivo->getClientOriginalExtension();
                $rutaESP = Storage::disk('local')->putFileAs($carpeta, $espArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_especificaciones = $rutaESP;
            }

            // Sube el archivo de monografia si está presente
            if ($request->hasFile('monografia')) {
                $monoArchivo = $request->file('monografia');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_monografia' . $monoArchivo->getClientOriginalExtension();
                $rutaMONO = Storage::disk('local')->putFileAs($carpeta, $monoArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_monografia = $rutaMONO;
            }

            // Sube el archivo de info nutricional si está presente
            if ($request->hasFile('infonut')) {
                $infonutArchivo = $request->file('infonut');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_monografia' . $infonutArchivo->getClientOriginalExtension();
                $rutaINFONUT = Storage::disk('local')->putFileAs($carpeta, $infonutArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_infonut = $rutaINFONUT;
            }

            // Sube el archivo de rotulo si está presente
            if ($request->hasFile('rotulo')) {
                $rotuloArchivo = $request->file('rotulo');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_rotulo' . $rotuloArchivo->getClientOriginalExtension();
                $rutaRotulo = Storage::disk('local')->putFileAs($carpeta, $rotuloArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_rotulo = $rutaRotulo;
            }
            // Sube el archivo de informacion si está presente
            if ($request->hasFile('certenvase')) {
                $certenvArchivo = $request->file('certenvase');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_certenvase' . $certenvArchivo->getClientOriginalExtension();
                $rutaCERTENV = Storage::disk('local')->putFileAs($carpeta, $certenvArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_certenvase = $rutaCERTENV;
            }

            // Sube el archivo de pago si está presente
            if ($request->hasFile('pago')) {
                $pagoArchivo = $request->file('pago');
                $carpeta = 'empresa/' . $idEmpresa . '/rpadb/' . $idRpadb; // Ajuste en la generación de la ruta

                // Crear la carpeta si no existe
                if (!Storage::exists($carpeta)) {
                    Storage::makeDirectory($carpeta);
                }

                $identificacion = date('dmY') . '_pago' . $pagoArchivo->getClientOriginalExtension();
                $rutaPago = Storage::disk('local')->putFileAs($carpeta, $pagoArchivo, $identificacion);
                // Actualizar la ruta del archivo adjunto en el modelo
                $rpadb->ruta_pago = $rutaPago;
            }
        }
        $rpadb->save(); // Insertar registro
        // Crea un nuevo registro en dbhistorials
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha_inicio = Carbon::now();
        $dbhistorial->area = 'PRODUCTOR';
        $dbhistorial->motivo = 'INSCRIPCION PRODUCTO - ' . $rpadb->denominacion;
        $dbhistorial->estado = 'OBSERVADO';
        $dbhistorial->observaciones = $request->input('observaciones'); // Agrega la observación aquí
        $dbhistorial->user_id = Auth::id();
        $dbhistorial->dbempresa_id = $rpadb->dbempresa_id;
        $dbhistorial->dbrpadb_id = $rpadb->id; // Supongo que el campo 'id' es la clave primaria de Dbrpadb
        $dbhistorial->save();
        $notification = 'El registro fué ACTUALIZADO correctamente.';
        return redirect('/rpadb/index')->with(compact('notification'));
    

    }


    public function certificado($id)
    {
        $rpadb = Dbrpadb::find($id);
        /* $dbrubro = Dbrubro::pluck('dbrubro'); */

        return view('db.rpadb.certificado')->with(compact('rpadb')); // imprimir
    } 
    public function getRubros($id){
        $rubros = DbredbDbrubro::where('dbrubro_id', $id)->get();
        return response()->json($categorias);
    }

    public function verANALISIS($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_analisis);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verING($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_ingredientes);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verESP($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_especificaciones);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verMONO($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_monografia);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verINFO($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_infonut);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verROTULO($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_rotulo);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verCERTENVASE($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_certenvase);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verPAGO($id)
    {
        $rpadb = Dbrpadb::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$rpadb->ruta_pago);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
}
