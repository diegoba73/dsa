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
        if (Auth::user()->role_id == 15) {
            $user = Auth::user();
            $idEmpresa = null;
    
            if ($user->empresa()->exists()) {
                $idEmpresa = $user->empresa->first()->id;
            }
    
            if ($idEmpresa !== null) {
                $redbs = Dbredb::where('dbempresa_id', $idEmpresa)
                    ->orderBy('id', 'DESC')
                    ->paginate(20);
            } else {
                // Manejar el caso en el que el usuario no tiene empresas asociadas
                // Por ejemplo, mostrar un mensaje de error
                $redbs = Dbredb::where('id', 0)->paginate(20);
            }
        } else {
            $idEmpresa = null;
            $numero = $request->get('numero');
            $razon = $request->get('razon');
            $redbs = Dbredb::orderBy('id', 'DESC')
                ->numero($numero)
                ->razon($razon)
                ->paginate(20);
        }
    
        return view('db.redb.index')->with(compact('redbs', 'idEmpresa'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $dbempresa  = Dbempresa::where('user_id', $user_id)->get();
        $redb = Dbredb::all();
        $dbrubros  = Dbrubro::all();
        $dbbajas  = Dbbaja::all();
        $dbcategorias  = Dbcategoria::all();
        $localidads  = Localidad::all();

        return view('db.redb.create')->with(compact('dbempresa', 'redb', 'dbrubros', 'dbbajas', 'dbcategorias', 'localidads'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $redb = new Dbredb();

        $redb->razon = $request->input('razon');
        $redb->domicilio = $request->input('domicilio');
        $redb->localidad_id = $request->input('localidad_id');
        $redb->fecha_inscripcion = $request->input('fecha_inscripcion');
        $fechaReinscripcion = Carbon::now()->addYears(5)->toDateString();
        $redb->fecha_reinscripcion = $fechaReinscripcion;
        $user = Auth::user();
        $redb->user_id = $user->id;
        $idEmpresa = $user->empresa->first()->id;
        $redb->dbempresa_id = $idEmpresa;
        $idRedb = $redb->id; // Obtener el ID del registro de redb

    // Sube el archivo de analisis si está presente
    if ($request->hasFile('analisis')) {
        $analisisArchivo = $request->file('analisis');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_analisis_' . $request->input('empresa') . '.' . $analisisArchivo->getClientOriginalExtension();
        $rutaANALISIS = Storage::disk('local')->putFileAs($carpeta, $analisisArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_analisis = $rutaANALISIS;

    }

        // Sube el archivo de memoria si está presente
    if ($request->hasFile('memoria')) {
        $memoriaArchivo = $request->file('memoria');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_memoria_' . $request->input('empresa') . '.' . $memoriaArchivo->getClientOriginalExtension();
        $rutaMEMORIA = Storage::disk('local')->putFileAs($carpeta, $memoriaArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_memoria = $rutaMEMORIA;

    }

    // Sube el archivo de habilitacion si está presente
    if ($request->hasFile('habilitacion')) {
        $habArchivo = $request->file('habilitacion');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_habilitacion_' . $request->input('empresa') . '.' . $habArchivo->getClientOriginalExtension();
        $rutaHAB = Storage::disk('local')->putFileAs($carpeta, $habArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_habilitacion = $rutaHAB;

    }

     // Sube el archivo de contrato si está presente
     if ($request->hasFile('contrato')) {
        $contratoArchivo = $request->file('contrato');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_contrato_' . $request->input('empresa') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaCONTRATO = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_contrato = $rutaCONTRATO;

    }  

     // Sube el archivo de plano si está presente
     if ($request->hasFile('plano')) {
        $planoArchivo = $request->file('plano');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_plano_' . $request->input('empresa') . '.' . $planoArchivo->getClientOriginalExtension();
        $rutaPLANO = Storage::disk('local')->putFileAs($carpeta, $planoArchivo, $identificacion);
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_plano = $rutaPLANO;

    }  
        $redb->save(); // Insertar registro
        $rubros = $request->input('rubro');
        $categorias = $request->input('categoria');
        $actividades = $request->input('actividad');

        foreach ($rubros as $index => $rubroId) {
            $categoriaActual = $categorias[$index];
            $actividadActual = $actividades[$index];

            // Utilizar attach para agregar la relación sin eliminar existentes
            $redb->rubros()->attach($rubroId, [
                'dbcategoria_id' => $categoriaActual,
                'actividad' => $actividadActual
            ]);
        }

        // Crear un nuevo registro en Dbhistorial
        $dbhistorial = new Dbhistorial();
        $dbhistorial->fecha_inicio = Carbon::now();
        $ultimoIngresado = Dbredb::latest()->where('user_id', Auth::id())->first();
        $dbhistorial->area = 'INICIO';
        $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO - ' . $ultimoIngresado->razon;
        $dbhistorial->estado = 'PENDIENTE';
        $dbhistorial->user_id = Auth::id();
        $dbhistorial->dbempresa_id = $idEmpresa;
        $dbhistorial->dbredb_id = $ultimoIngresado->id; // Supongo que el campo 'id' es la clave primaria de Dbredb

        $dbhistorial->save();

        $notification = 'El registro fué INGRESADO correctamente.';
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
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    $redb = Dbredb::findOrFail($id);
    $rubros = Dbrubro::with('categorias')->get();
    $dbbajas = Dbbaja::all();
    $user = User::all();
    $pivotcat = DB::table('dbredb_dbrubro')->where('dbredb_id', $id)->get();
    $rubroIds = $pivotcat->pluck('dbrubro_id'); // Obtener solo los dbcategoria_id
    $categoriaIds = $pivotcat->pluck('dbcategoria_id'); // Obtener solo los dbcategoria_id
    $dbrubros = Dbrubro::whereIn('id', $rubroIds)->get();
    $dbcategorias = Dbcategoria::whereIn('id', $categoriaIds)->get();
    $localidads = Localidad::all();
    $historial = Dbhistorial::where('dbredb_id', $id)->latest()->first();
    return view('db.redb.edit', compact('redb', 'rubros', 'dbbajas', 'user', 'dbrubros', 'dbcategorias', 'localidads', 'historial'));
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
    $redb = Dbredb::findOrFail($id);
    $redb->razon = $request->input('razon');
    $redb->domicilio = $request->input('domicilio');
    $redb->localidad_id = $request->input('localidad_id');
    $redb->fecha_inscripcion = $request->input('fecha_inscripcion');
    $redb->expediente = $request->input('expediente');
    if ($request->filled('expediente')) {
        // Solo ejecuta este bloque si el campo 'expediente' tiene datos
        
        // Obtener el valor máximo de la columna 'numero'
        $maxNumero = Dbredb::max('numero');
    
        // Calcular el siguiente número, asegurándose de que sea al menos 1
        $redb->numero = ($maxNumero !== null && $maxNumero > 0) ? $maxNumero + 1 : 1;
    }
    $idRedb =   $redb->id;
    $idEmpresa = $redb->dbempresa_id;

    // Sube el archivo de dni si está presente
    if ($request->hasFile('dni')) {
        $contratoArchivo = $request->file('dni');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_dni_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaDNI = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_dni = $rutaDNI;
    }

    if ($request->hasFile('cuit')) {
        $contratoArchivo = $request->file('cuit');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_cuit_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaCUIT = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_cuit = $rutaCUIT;
    }

    if ($request->hasFile('estatuto')) {
        $contratoArchivo = $request->file('estatuto');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_dni_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaESTATUTO = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_dni = $rutaESTATUTO;
    }
 
    // Sube el archivo de analisis si está presente
    if ($request->hasFile('analisis')) {
        $contratoArchivo = $request->file('analisis');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_analisis_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaANALISIS = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_analisis = $rutaANALISIS;
    }

    // Sube el archivo de analisis si está presente
    if ($request->hasFile('memoria')) {
        $contratoArchivo = $request->file('memoria');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_memoria_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaMEMORIA = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_memoria = $rutaMEMORIA;
    }

    // Sube el archivo de analisis si está presente
    if ($request->hasFile('contrato')) {
        $contratoArchivo = $request->file('contrato');
        $carpeta = 'empresa/' . $idEmpresa . '/redb/' . $idRedb; // Ajuste en la generación de la ruta
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_contrato_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaCONTRATO = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_contrato = $rutaCONTRATO;
    }

    if ($request->hasFile('habilitacion')) {
        $contratoArchivo = $request->file('habilitacion');
        $carpeta = 'empresa/redb/' . $redb->numero;
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_habilitacion_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaHAB = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_habilitacion = $rutaHAB;
    }

    // Sube el archivo de plano si está presente
    if ($request->hasFile('plano')) {
        $contratoArchivo = $request->file('plano');
        $carpeta = 'empresa/redb/' . $redb->numero;
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_plano_' . $request->input('razon') . '.' . $contratoArchivo->getClientOriginalExtension();
        $rutaPLANO = Storage::disk('local')->putFileAs($carpeta, $contratoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $redb->ruta_plano = $rutaPLANO;
    }  

    $redb->user_id = $this->auth->user()->id;
    // Guardar los cambios en la base de datos
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
    // Crea un nuevo registro en dbhistorials
    $dbhistorial = new Dbhistorial();
    $dbhistorial->fecha_inicio = Carbon::now();
    $dbhistorial->area = 'PRODUCTOR';
    $dbhistorial->motivo = 'INSCRIPCION ESTABLECIMIENTO - ' . $redb->razon;
    $dbhistorial->estado = 'OBSERVADO';
    $dbhistorial->observaciones = $request->input('observaciones'); // Agrega la observación aquí
    $dbhistorial->user_id = Auth::id();
    $dbhistorial->dbempresa_id = $redb->dbempresa_id;
    $dbhistorial->dbredb_id = $redb->id; // Supongo que el campo 'id' es la clave primaria de Dbrpadb
    $dbhistorial->save();

    $notification = 'El registro fué ACTUALIZADO correctamente.';
    return redirect('/redb/index')->with(compact('notification'));
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

    public function certificado($id)
    {
        $redb = Dbredb::find($id);
        /* $dbrubro = Dbrubro::pluck('dbrubro'); */

        return view('db.redb.certificado')->with(compact('redb')); // imprimir
    } 

    public function getCategorias($id){
        $categorias = Dbcategoria::where('dbrubro_id', $id)->get();
        return response()->json($categorias);
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
}
