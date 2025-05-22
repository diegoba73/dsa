<?php

namespace App\Http\Controllers;

use App\Dbdt;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Dbredb;

class DbdtController extends Controller
{
    // Mostrar una lista de registros
    public function index(Request $request)
    {            
        $dni = $request->get('dni');
        $nombre = $request->get('nombre');
        $dbdts = Dbdt::orderBy('id', 'desc')
            ->dni($dni)
            ->nombre($nombre)
            ->latest('id')
            ->paginate(20);
        $dbdts->appends($request->only(['dni', 'nombre']));
        return view('db.dt.index')->with(compact('dbdts'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        return view('db.dt.create');
    }

    // Guardar un nuevo registro
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'dni' => 'required|max:255',
            'titulo' => 'required|max:255',
            'domicilio' => 'required|max:255',
            'ciudad' => 'required|max:100',
            'telefono' => 'required|max:45',
            'email' => 'required|email|max:45',
            'universidad' => 'required|max:200',
            'matricula' => 'required|max:45',
            'dni_file' => 'required|file|mimes:pdf',
            'titulo_file' => 'required|file|mimes:pdf',
            'cv_file' => 'required|file|mimes:pdf',
            'cert_domicilio_file' => 'required|file|mimes:pdf',
            'arancel_file' => 'required|file|mimes:pdf',
            'foto_file' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);
    
        $dbdt = Dbdt::create($validatedData);
        $idDbdt = $dbdt->id;
        $carpeta = 'dts/' . $idDbdt;
        Storage::disk('local')->makeDirectory($carpeta);
    
        $fileFields = ['dni', 'titulo', 'cv', 'cert_domicilio', 'antecedentes', 'arancel', 'foto'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field . '_file')) {
                // Elimina el archivo anterior si existe
                if ($dbdt->{'ruta_' . $field}) {
                    Storage::disk('local')->delete($dbdt->{'ruta_' . $field});
                }
        
                // Guardar el nuevo archivo
                $file = $request->file($field . '_file');
                $extension = $file->extension();
                $path = Storage::disk('local')->putFileAs($carpeta, $file, $field . '.' . $extension);
                $dbdt->{'ruta_' . $field} = $path;
            }
        }     
        $dbdt->fecha_inscripcion = Carbon::now();  
        $fechaReinscripcion = Carbon::now()->addYears(5)->toDateString();
        $dbdt->fecha_reinscripcion = $fechaReinscripcion;
        $dbdt->save();
    
        return redirect()->route('db_dt_index')->with('success', 'Registro creado correctamente.');
    }

    // Mostrar un registro específico
    public function show($id)
    {
        $dt = Dbdt::with('redbs')->findOrFail($id);
        $redb = $dt->redbs->first();
    
        return view('db.dt.show', compact('dt', 'redb'));
    }

    public function generatePDF($id)
    {
        $dt = Dbdt::with('redbs')->findOrFail($id);
        $redb = $dt->redbs->first();
    
        $pdf = PDF::loadView('db.dt.pdf', compact('dt', 'redb'));
    
        $dompdf = $pdf->getDomPDF();
        $dompdf->setPaper([0, 0, 242.64, 306.92], 'portrait'); // Tamaño total de la hoja
    
        return $pdf->download('carnet_dt_' . $dt->id . '.pdf');
    }       

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $dt = Dbdt::findOrFail($id);
        $redbs = Dbredb::all(); // Obtenemos todos los REDBs
        return view('db.dt.edit', compact('dt', 'redbs'));
    }
    
public function update(Request $request, $id)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'nombre' => 'required|max:255',
        'dni' => 'required|max:255',
        'titulo' => 'required|max:255',
        'domicilio' => 'required|max:255',
        'ciudad' => 'required|max:100',
        'telefono' => 'required|max:45',
        'email' => 'required|email|max:45',
        'universidad' => 'required|max:200',
        'matricula' => 'required|max:45',
        'dni_file' => 'nullable|file|mimes:pdf',
        'titulo_file' => 'nullable|file|mimes:pdf',
        'cv_file' => 'nullable|file|mimes:pdf',
        'cert_domicilio_file' => 'nullable|file|mimes:pdf',
        'arancel_file' => 'nullable|file|mimes:pdf',
        'foto_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'dbredbs' => 'nullable|array',
        'dbredbs.*' => 'exists:dbredbs,id',
    ]);

    // Encontrar el registro por ID
    $dbdt = Dbdt::findOrFail($id);

    // Actualizar los datos básicos
    $dbdt->update($validatedData);

    // Definir la carpeta de almacenamiento
    $carpeta = 'dts/' . $dbdt->id;

    // Crear la carpeta si no existe
    if (!Storage::disk('local')->exists($carpeta)) {
        Storage::disk('local')->makeDirectory($carpeta);
    }

    // Campos de archivos
    $fileFields = ['dni', 'titulo', 'cv', 'cert_domicilio', 'antecedentes', 'arancel', 'foto'];

    // Procesar y guardar los archivos
    foreach ($fileFields as $field) {
        if ($request->hasFile($field . '_file')) {
            // Elimina el archivo anterior si existe
            if ($dbdt->{'ruta_' . $field}) {
                Storage::disk('local')->delete($dbdt->{'ruta_' . $field});
            }
    
            // Guardar el nuevo archivo
            $file = $request->file($field . '_file');
            $extension = $file->extension();
            $path = Storage::disk('local')->putFileAs($carpeta, $file, $field . '.' . $extension);
            $dbdt->{'ruta_' . $field} = $path;
        }
    }

    // Guardar los cambios
    $dbdt->save();
    // Desvincular cualquier establecimiento anterior
    Dbredb::where('dbdt_id', $dbdt->id)->update(['dbdt_id' => null]);

    // Vincular los REDBs seleccionados
    if ($request->has('dbredbs')) {
        Dbredb::whereIn('id', $request->input('dbredbs'))
            ->update(['dbdt_id' => $dbdt->id]);
    }
    // Redirigir con mensaje de éxito
    return redirect()->route('db_dt_index')->with('success', 'Registro actualizado correctamente.');
}

public function verDNI($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_dni);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verTITULO($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_titulo);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verCV($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_cv);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verCERT($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_cert_domicilio);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verANTECEDENTE($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_antecedentes);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verARANCEL($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/'.$dt->ruta_arancel);
    $headers = [
        'Content-Type' => 'application/pdf',
    ];

    return response()->file($rutaArchivo, $headers);
}

public function verFOTO($id)
{
    $dt = Dbdt::findOrFail($id);
    $rutaArchivo = storage_path('app/' . $dt->ruta_foto);

    if (!file_exists($rutaArchivo)) {
        abort(404, 'Archivo no encontrado.');
    }

    // Detectar el tipo MIME del archivo automáticamente
    $mime = mime_content_type($rutaArchivo);

    return response()->file($rutaArchivo, ['Content-Type' => $mime]);
}

}
