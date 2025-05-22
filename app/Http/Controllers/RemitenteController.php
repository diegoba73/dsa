<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Remitente;
use App\Localidad;
use App\User;

class RemitenteController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $remitente      = $request->get('remitente');
        $direccion      = $request->get('direccion');
        $remitentes = Remitente::orderBy('remitentes.id', 'DESC')
        ->remitente($remitente)
        ->direccion($direccion)
        ->paginate(20);
        $localidades = Localidad::all();
        return view('admin.remitentes.index')->with(compact('remitentes', 'localidades')); // listado remitentes
    }

    public function create()
    {
        $remitentes = Remitente::all();
        $localidads = Localidad::all();
        $users = User::all();
        return view('admin.remitentes.create')->with(compact('remitentes', 'localidads', 'users'));  // formulario remitente
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data (basic requirements)
        $request->validate([
            'cuit' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'localidad_id' => 'required|exists:localidads,id',
        ]);

        // Check if CUIT already exists
        $existingRemitenteByCuit = Remitente::where('cuit', $request->input('cuit'))->first();

        if ($existingRemitenteByCuit) {
            // CUIT exists
            $existingRemitenteByName = Remitente::where('nombre', $request->input('nombre'))->first();
            if ($existingRemitenteByName) {
                // Both CUIT and name exist, do not register
                $request->validate([
                    'cuit' => 'unique:remitentes,cuit',
                    'nombre' => 'unique:remitentes,nombre',
                ]);
            }
            // If the name does not exist, register
        } else {
            // CUIT does not exist
            $existingRemitenteByName = Remitente::where('nombre', $request->input('nombre'))->first();
            if ($existingRemitenteByName) {
                // Name exists, check if the address exists
                $existingRemitenteByAddress = Remitente::where('direccion', $request->input('direccion'))->first();
                if ($existingRemitenteByAddress) {
                    // Name and address exist, do not register
                    $request->validate([
                        'nombre' => 'unique:remitentes,nombre',
                        'direccion' => 'unique:remitentes,direccion',
                    ]);
                }
                // If the address does not exist, register
            }
            // If the name does not exist, register
        }
        $remitente = new Remitente();
        $remitente->nombre = $request->input('nombre');
        $remitente->cuit = $request->input('cuit');
        $remitente->responsable = $request->input('responsable');
        $remitente->area = $request->input('area');
        $remitente->email = $request->input('email');
        $remitente->direccion = $request->input('direccion');
        $remitente->telefono = $request->input('telefono');
        $remitente->localidad_id = $request->input('localidad_id');
        $remitente->user_id = $request->input('user_id');
        $remitente->save(); // Insert remito
        $notification = 'El remitente fué INGRESADO correctamente.';
        return redirect('/admin/remitentes/index')->with(compact('notification'));
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
    public function edit($id)
    {
        $remitente = Remitente::find($id);
        $localidads = Localidad::all();
        $users = User::all();
        return view('admin.remitentes.edit')->with(compact('remitente', 'localidads', 'users'));  // editar remitente    
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
        $request->validate([
            'nombre' => 'required|string|max:255' . $id,
            'cuit' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'localidad_id' => 'required|exists:localidads,id',
        ]);
        $remitente = Remitente::find($id);
        $remitente->nombre = $request->input('nombre');
        $remitente->cuit = $request->input('cuit');
        $remitente->responsable = $request->input('responsable');
        $remitente->area = $request->input('area');
        $remitente->email = $request->input('email');
        $remitente->direccion = $request->input('direccion');
        $remitente->telefono = $request->input('telefono');
        $remitente->localidad_id = $request->input('localidad_id');
        $remitente->user_id = $request->input('user_id');
        $remitente->save(); // Insert remito
        $notification = 'El remitente fué ACTUALIZADO correctamente.';
        return redirect()->route('remitentes_index', array('id' => $id))->with(compact('notification'));

    }

    public function destroy(Request $request)
    {
        
        $remitente = Remitente::findOrFail($request->id);
        $remitente->delete();
        $notification = 'El remitente "'. $remitente->nombre .'" fué ELIMINADO correctamente.';
        return redirect('/admin/remitentes/index')->with(compact('notification'));

        return back();

    }
}

