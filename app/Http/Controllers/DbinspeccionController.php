<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Dbinspeccion;
use App\Localidad;
use App\Dbredb;

class DbinspeccionController extends Controller
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
        $user = Auth::user();
        $establecimiento = $request->get('establecimiento');

        // Consulta base
        $query = Dbinspeccion::with('dbredb.localidad')->orderBy('id', 'DESC');

        // Filtro por establecimiento (si aplica)
        if ($establecimiento) {
            $query->whereHas('dbredb', function ($q) use ($establecimiento) {
                $q->where('establecimiento', 'like', "%{$establecimiento}%");
            });
        }

        // Filtro por zona según el rol
        if ($user->role_id == 9) {
            // Nivel Central → solo zona NC
            $query->whereHas('dbredb.localidad', function ($q) {
                $q->where('zona', 'NC');
            });
        } elseif (in_array($user->role_id, [16, 17, 18])) {
            // Área Programática → según su zona
        switch ($user->role_id) {
            case 16:
                $zona = 'ape';
                break;
            case 17:
                $zona = 'apcr';
                break;
            case 18:
                $zona = 'appm';
                break;
            default:
                $zona = null;
                break;
        }

            $query->whereHas('dbredb.localidad', function ($q) use ($zona) {
                $q->where('zona', $zona);
            });
        }
        // Admin ve todo

        $inspecciones = $query->paginate(20);
        $dbredb = Dbredb::all();

        return view('db.inspecciones.index')->with(compact('inspecciones', 'dbredb'));
    }

    public function create()
    {
        $establecimientos = Dbredb::where('finalizado', true)->select('id', 'numero', 'establecimiento', 'transito')->get(); // Selecciona 'numero'
        $localidads = Localidad::all();
    
        return view('db.inspecciones.create')->with(compact('establecimientos', 'localidads'));
    }

    public function store(Request $request)
    {
        $inspeccion = new Dbinspeccion();
        $inspeccion->fecha = $request->input('fecha');
    
        $inspeccion->establecimiento = $request->input('establecimiento');
        $inspeccion->dbredb_id = $request->input('dbredb_id');    
        $inspeccion->direccion = $request->input('direccion');
        $inspeccion->localidad_id = $request->input('localidad_id');
        $inspeccion->rubro = $request->input('rubro');
        $inspeccion->motivo = $request->input('motivo');
        $inspeccion->detalle = $request->input('detalle');
        $inspeccion->higiene = $request->input('higiene');
        $inspeccion->user_id = Auth::id();
    
        // Guardar el registro
        $inspeccion->save();
    
        $notification = 'Se hizo el INGRESO correctamente.';
        return redirect('/inspecciones/index')->with(compact('notification'));
    }

    public function edit($id)
    {
        $inspeccion = Dbinspeccion::findOrFail($id);
        $establecimientos = Dbredb::all();
        $localidads = Localidad::all();

        return view('db.inspecciones.edit')->with(compact('inspeccion', 'establecimientos', 'localidads'));
    }

    public function update(Request $request, $id)
    {
        $inspeccion = Dbinspeccion::findOrFail($id);
        $inspeccion->fecha = $request->input('fecha');
        $inspeccion->establecimiento = $request->input('establecimiento');
        $inspeccion->dbredb_id = $request->input('dbredb_id');
        $inspeccion->direccion = $request->input('direccion');
        $inspeccion->localidad_id = $request->input('localidad_id');
        $inspeccion->rubro = $request->input('rubro');
        $inspeccion->motivo = $request->input('motivo');
        $inspeccion->detalle = $request->input('detalle');
        $inspeccion->higiene = $request->input('higiene');

        // No actualizamos el user_id para evitar cambios en el creador de la inspección

        $inspeccion->save();

        $notification = 'Se actualizó la inspección correctamente.';
        return redirect('/inspecciones/index')->with(compact('notification'));
    }

}
