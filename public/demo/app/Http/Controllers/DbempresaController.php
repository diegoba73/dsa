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
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\User;
use App\Dbempresa;
use \PDF;
use Session;

class DbempresaController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $empresa = $request->get('empresa');
        if (Auth::user()->role_id == 15) {
            $user = Auth::user()->id;
            $dbempresas = Dbempresa::where('user_id', $user)
            ->empresa($empresa)
            ->paginate(20);
        } else {
            $dbempresas = Dbempresa::orderBy('dbempresas.id', 'DESC')
            ->empresa($empresa)
            ->paginate(20);
        }        
    
        return view('db.empresa.index')->with(compact('dbempresas')); // listado empresas
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dbempresa = Dbempresa::all();
        $users = User::where('role_id', 15)->get();
        return view('db.empresa.create')->with(compact('dbempresa', 'users'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $messages = [
        'cuit.required' => 'El número de CUIT es obligatorio',
        'cuit.unique' => 'El número de CUIT ya está en uso',
        'empresa.required' => 'La empresa es obligatoria',
        'user_id.required' => 'El usuario es obligatorio',
        ];

        $rules = [
            'cuit' => 'required|unique:dbempresas,cuit',
            'empresa' => 'required',
            'user_id' => 'required',
            // Agrega las demás reglas aquí
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dbempresa = new Dbempresa();
        $dbempresa->cuit = $request->input('cuit');
        $dbempresa->empresa = $request->input('empresa');
        $dbempresa->domicilio = $request->input('domicilio');
        $dbempresa->ciudad = $request->input('ciudad');
        $dbempresa->provincia = $request->input('provincia');
        $dbempresa->telefono = $request->input('telefono');
        $dbempresa->email = $request->input('email');
        $dbempresa->user_id = $request->input('user_id');
        $dbempresa->saveOrFail(); // Insertar registro
        $user = $dbempresa->user; // Obtener el usuario asociado
        $notification = 'La empresa fue ingresada correctamente por ' . $user->name;
        return redirect('/empresa/index')->with('success', $notification);
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
    $dbempresa = Dbempresa::findOrFail($id);
    $users = User::where('role_id', 15)->get();
    return view('db.empresa.edit', compact('dbempresa', 'users'));
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
    $dbempresa = Dbempresa::findOrFail($id);
    $dbempresa->cuit = $request->input('cuit');
    $dbempresa->empresa = $request->input('empresa');
    $dbempresa->domicilio = $request->input('domicilio');
    $dbempresa->ciudad = $request->input('ciudad');
    $dbempresa->provincia = $request->input('provincia');
    $dbempresa->telefono = $request->input('telefono');
    $dbempresa->email = $request->input('email');
    $dbempresa->user_id = $request->input('user_id');

    // Sube el archivo de dni si está presente
    if ($request->hasFile('dni')) {
        $dniArchivo = $request->file('dni');
        $carpeta = 'empresa/' . $id;
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_dni_' . $request->input('empresa') . '.' . $dniArchivo->getClientOriginalExtension();
        $rutaDNI = Storage::disk('local')->putFileAs($carpeta, $dniArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $dbempresa->ruta_dni = $rutaDNI;
    }

    // Sube el archivo de cuit si está presente
    if ($request->hasFile('cuit')) {
        $cuitArchivo = $request->file('cuit');
        $carpeta = 'empresa/' . $id;
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_cuit_' . $request->input('empresa') . '.' . $cuitArchivo->getClientOriginalExtension();
        $rutaCUIT = Storage::disk('local')->putFileAs($carpeta, $cuitArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $dbempresa->ruta_cuit = $rutaCUIT;
    }

    if ($request->hasFile('estatuto')) {
        $estatutoArchivo = $request->file('estatuto');
        $carpeta = 'empresa/' . $id;
    
        // Crear la carpeta si no existe
        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }
    
        $identificacion = date('dmY') . '_estatuto_' . $request->input('empresa') . '.' . $estatutoArchivo->getClientOriginalExtension();
        $rutaESTATUTO = Storage::disk('local')->putFileAs($carpeta, $estatutoArchivo, $identificacion);
    
        // Actualizar la ruta del archivo adjunto en el modelo
        $dbempresa->ruta_estatuto = $rutaESTATUTO;
    }

    // Guardar los cambios en la base de datos
    $dbempresa->save();
    $notification = 'El registro fué ACTUALIZADO correctamente.';
    return redirect()->route('db_empresa_index')->with(compact('notification'));
}


    public function adjuntarDocumentos(Request $request, $dbempresa_id)
    {
        // Validación y almacenamiento de los documentos adjuntos
        $request->validate([
            'contrato' => 'required|file|mimes:pdf,docx|max:2048', // Ajusta las reglas de validación según tus necesidades
            'habilitacion' => 'required|file|mimes:pdf,docx|max:2048',
            'plano' => 'required|file|mimes:pdf,docx|max:2048',
        ]);

        $dbempresa = Dbempresa::find($dbempresa_id);

        if (!$dbempresa) {
            // Maneja el caso en el que no se encuentra el registro dbempresa
        }

        // Subir el documento de Contrato
        if ($request->hasFile('contrato')) {
            $contrato = $request->file('contrato');
            $contratoNombre = $contrato->getClientOriginalName();
            $contrato->storeAs('documentos', $contratoNombre, 'public'); // Almacena el contrato en la carpeta 'public/documentos'
            $dbempresa->contrato = 'documentos/' . $contratoNombre;
        }

        // Repite el proceso para los documentos de Habilitación y Plano de manera similar.

        // Guarda el registro dbempresa con los datos actualizados.
        $dbempresa->save();

        return redirect()->back()->with('notification', 'Documentos adjuntados con éxito.');
    }

    public function certificado($id)
    {
        $dbempresa = Dbempresa::find($id);

        return view('db.empresa.certificado')->with(compact('dbempresa')); // imprimir
    } 

    public function verDNI($id)
    {
        $dbempresa = Dbempresa::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$dbempresa->ruta_dni);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }
    public function verCUIT($id)
    {
        $dbempresa = Dbempresa::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$dbempresa->ruta_cuit);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }


    public function verESTATUTO($id)
    {
        $empresa = Dbempresa::findOrFail($id);
        $rutaArchivo = storage_path('app/'.$empresa->ruta_estatuto);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->file($rutaArchivo, $headers);
    }

}
