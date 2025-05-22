<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Departamento;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request, User $model)
    {
        $currentUser = auth()->user();
        $search = $request->input('search');
    
        $users = $model->query()
            ->when($currentUser->departamento_id == 2, function ($query) {
                // Solo usuarios del mismo departamento (DB)
                $query->where('departamento_id', 2);
            })
            ->when($search, function ($query, $search) {
                // Búsqueda por usuario o email
                $query->where(function ($q) use ($search) {
                    $q->where('usuario', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['search' => $search]); // mantiene el valor del buscador en la paginación
    
        return view('users.index', ['users' => $users]);
    }
    

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = new User();
        $currentUser = auth()->user();
        
        if ($currentUser->departamento_id == 2) { // Si el usuario pertenece al departamento "DB"
            $departamentos = Departamento::where('id', 2)->get();
            $roles = Role::whereIn('id', [15, 16, 17, 18])->get();
        } else {
            $departamentos = Departamento::all();
            $roles = Role::all();
        }
        
        return view('users.create', compact('user', 'departamentos', 'roles'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $currentUser = auth()->user();
        
        if ($currentUser->departamento_id == 2) {
            if ($request->departamento_id != 2 || !in_array($request->role_id, [15, 16, 17, 18])) {
                return redirect()->back()->withErrors(['No tienes permiso para crear un usuario con ese departamento o rol.']);
            }
        }
    
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());
    
        return redirect()->route('user.index')->withStatus(__('Usuario creado correctamente.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $departamentos = Departamento::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'departamentos', 'roles'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

    public function toggleStatus(User $user)
    {
        // Cambia el valor del campo "activo" en función de su estado actual
        $user->activo = $user->activo ? 0 : 1;
        $user->save();

        // Redirige de vuelta a la página de edición del usuario
        return redirect()->route('user.edit', $user)->withStatus(__('Estado del usuario actualizado.'));
    }
}
