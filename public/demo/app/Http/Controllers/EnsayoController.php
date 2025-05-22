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
use App\User;
use App\Ensayo;
use App\Matriz;
use App\Modulo;
use App\Nomenclador;
 
class EnsayoController extends Controller
{
    public $timestamps = false;//

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $codigo       = $request->get('codigo');
        $tipo_ensayo = $request->get('tipo_ensayo');
        $ensayo = $request->get('ensayo');
        $ensayos = Ensayo::orderBy('ensayos.id', 'DESC')
                    ->codigo($codigo)
                    ->tipoensayo($tipo_ensayo)
                    ->ensayo($ensayo)
                    ->paginate(20);

        return view('lab.ensayos.index')->with(compact('ensayos')); // listado notas DSO
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ensayos = Ensayo::all();
        $matrizs  = Matriz::all();

        return view('lab.ensayos.create')->with(compact('ensayos', 'matrizs'));  // formulario nota
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'codigo.required' => 'El código es requerido',
            'tipo_ensayo.required' => 'El tipo de ensayo es requerido',
            'ensayo.required' => 'El nombre del ensayo es requerido',
            'matriz_id.required' => 'La matriz es requerida',
        ];
        
        $rules = [
            'codigo' => 'required',
            'tipo_ensayo' => 'required',
            'ensayo' => 'required',
            'matriz_id' => 'required',
        ];

        $this->validate($request, $rules, $message);

        $ensayo = new Ensayo();
        $ensayo->codigo = $request->input('codigo');
        $ensayo->tipo_ensayo = $request->input('tipo_ensayo');
        $ensayo->ensayo = $request->input('ensayo');
        $ensayo->metodo = $request->input('metodo');
        $ensayo->norma_procedimiento = $request->input('norma_procedimiento');
        $ensayo->matriz_id = $request->input('matriz_id');
        $ensayo->unidades = $request->input('unidades');
        $ensayo->valor_referencia = $request->input('valor_referencia');
        $ensayo->limite_c = $request->input('limite_c');
        $ensayo->limite_d = $request->input('limite_d');
        $ensayo->costo = $request->input('costo');
        $ensayo->save(); // Insert nota
        $notification = 'El ensayo fué INGRESADO correctamente.';
        return redirect('/lab/ensayos/index')->with(compact('notification'));
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
        $ensayo = Ensayo::find($id);
        $matrizs = Matriz::all();
        $url = redirect()->getUrlGenerator()->previous();
        return view('lab.ensayos.edit')->with(compact('ensayo', 'matrizs', 'url'));  // editar nota    
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
        $ensayo = Ensayo::find($id);
        $ensayo->codigo = $request->input('codigo');
        $ensayo->tipo_ensayo = $request->input('tipo_ensayo');
        $ensayo->ensayo = $request->input('ensayo');
        $ensayo->metodo = $request->input('metodo');
        $ensayo->norma_procedimiento = $request->input('norma_procedimiento');
        $ensayo->matriz_id = $request->input('matriz_id');
        $ensayo->unidades = $request->input('unidades');
        $ensayo->valor_referencia = $request->input('valor_referencia');
        $ensayo->limite_c = $request->input('limite_c');
        $ensayo->limite_d = $request->input('limite_d');
        $ensayo->costo = $request->input('costo');
        $ensayo->save();
        $url = Input::get('url');
        $notification = 'El ensayo fué ACTUALIZADO correctamente.';
        return redirect($url)->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Ensayo $ensayo)
    {
        // Cambia el valor del campo "activo" en función de su estado actual
        $ensayo->activo = $ensayo->activo ? 0 : 1;
        $ensayo->save();

        $notification = 'Estado del ensayo actualizado.';
        return redirect('/lab/ensayos/index')->with(compact('notification'));
    }

    public function actualizar_modulo(Request $request)
    {
        // Lógica para crear un nuevo registro de Modulo
        $nuevoModulo = new Modulo();
        $nuevoModulo->valor = $request->input('valor'); // Reemplaza campo1 por el nombre real de tus campos
        $nuevoModulo->fecha = $request->input('fecha');
        // ... Continúa con los demás campos

        $nuevoModulo->save();

        // Lógica para actualizar precios
        $ultimoValor = Modulo::orderBy('id', 'desc')->value('valor');
        $valorAnterior = Modulo::orderBy('id', 'desc')->skip(1)->value('valor');

        if ($valorAnterior !== null) {
            // Realizar la división
            $coeficiente = $ultimoValor / $valorAnterior;

            // Actualizar el coeficiente del último registro existente en 'modulos'
            DB::table('modulos')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update(['coeficiente' => $coeficiente]);

            // Actualizar los precios en 'ensayos'
            Ensayo::query()->update(['costo' => DB::raw('costo * ' . $coeficiente)]);

            // Actualizar los precios en 'nomencladors'
            Nomenclador::query()->update(['valor' => DB::raw('valor * ' . $coeficiente)]);

            $notification = 'Se actualizaron los precios correctamente.';
            return redirect('/lab/ensayos/index')->with(compact('notification'));
        } else {
            $notification = 'No se actualizaron los precios.';
            return redirect('/lab/ensayos/index')->with(compact('notification'));
        }
    }
}
