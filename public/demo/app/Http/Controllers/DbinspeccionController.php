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
        $razon       = $request->get('razon');
        $direccion = $request->get('direccion');
        $inspecciones = Dbinspeccion::orderBy('id', 'DESC')
                    ->razon($razon)
                    ->direccion($direccion)
                    ->paginate(20);
        $dbredb = Dbredb::all();
        return view('db.inspecciones.index')->with(compact('inspecciones', 'dbredb')); // listado remitos db
    }
    public function create()
    {
        $razones = Dbredb::all();
        $localidads = Localidad::all();

        return view('db.inspecciones.create')->with(compact('razones', 'localidads'));  // formulario inspeccion
    }

    public function store(Request $request)
    {
        $inspeccion = new Dbinspeccion();
        $inspeccion->fecha = $request->input('fecha');
    
        $inspeccion->razon = $request->input('razon');
        $inspeccion->dbredb_id = $request->input('razon_id');    
        $inspeccion->direccion = $request->input('direccion');
        $inspeccion->localidad_id = $request->input('localidad_id');
        $inspeccion->rubro = $request->input('rubro');
        $inspeccion->motivo = $request->input('motivo');
        $inspeccion->detalle = $request->input('detalle');
        $inspeccion->higiene = $request->input('higiene');
        $inspeccion->user_id = $this->auth->user()->id;
    
        // Guardar el registro
        $inspeccion->save();
    
        $notification = 'Se hizo el INGRESO correctamente.';
        return redirect('/inspecciones/index')->with(compact('notification'));
    }

    public function edit($id)
    {
        $inspeccion = Dbinspeccion::findOrFail($id);
        $razones = Dbredb::all();
        $localidads = Localidad::all();

        return view('db.inspecciones.edit')->with(compact('inspeccion', 'razones', 'localidads'));
    }

    public function update(Request $request, $id)
    {
        $inspeccion = Dbinspeccion::findOrFail($id);
        $inspeccion->fecha = $request->input('fecha');
        $inspeccion->razon = $request->input('razon');
        $inspeccion->dbredb_id = $request->input('razon_id');
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
