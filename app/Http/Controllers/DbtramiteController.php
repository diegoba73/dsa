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
use App\Dbrpadb;
use App\Dbtramite;
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
use Illuminate\Support\Str;

class DbtramiteController extends Controller
{
    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
    
        // PRODUCTOR → empresa asociada
        $empresa = $user->role_id === 15 ? Dbempresa::where('user_id', $user->id)->first() : null;
        $empresaId = $empresa ? $empresa->id : null;
    
        // Mapear zona por rol de área (en minúsculas)
        $zonaPorRol = [
            16 => 'ape',   // Esquel
            17 => 'apcr',  // Comodoro
            18 => 'appm',  // Puerto Madryn
        ];
        $zonaUsuario = $zonaPorRol[$user->role_id] ?? null;
    
        $tramites = Dbtramite::with(['dbredb.localidad', 'dbrpadb.dbredb.localidad', 'dbempresa'])
    
            // PRODUCTOR: solo los de su empresa
            ->when($user->role_id === 15 && $empresaId, function ($query) use ($empresaId) {
                $query->where('dbempresa_id', $empresaId);
            })
    
            // EVALUADORES DE ÁREA: trámites cuya zona coincida con la suya
            ->when(in_array($user->role_id, [16, 17, 18]) && $zonaUsuario, function ($query) use ($zonaUsuario) {
                $query->where(function ($q) use ($zonaUsuario) {
                    $q->whereHas('dbredb.localidad', function ($q2) use ($zonaUsuario) {
                        $q2->where('zona', $zonaUsuario);
                    })->orWhereHas('dbrpadb.dbredb.localidad', function ($q3) use ($zonaUsuario) {
                        $q3->where('zona', $zonaUsuario);
                    });
                });
            })

            // NIVEL CENTRAL: excluir trámites en estado INICIADO, de zona ≠ nc, y que NO sean BAJA
            ->when($user->role_id === 9, function ($query) {
                $query->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->whereNotIn('estado', [
                                'INICIADO',
                                'OBSERVADO POR AUTORIDAD SANITARIA',
                                'REENVIADO POR EMPRESA'
                            ])
                            ->orWhere(function ($q3) {
                                $q3->where(function ($q4) {
                                    $q4->where('tipo_tramite', 'LIKE', '%BAJA ESTABLECIMIENTO%')
                                        ->orWhere('tipo_tramite', 'LIKE', '%BAJA PRODUCTO%');
                                })
                                ->orWhereHas('dbredb.localidad', fn($l) => $l->where('zona', 'nc'))
                                ->orWhereHas('dbrpadb.dbredb.localidad', fn($l2) => $l2->where('zona', 'nc'));
                            });
                    });
                });
            })
    
            // Filtros adicionales
            ->when($request->estado, fn($query, $estado) => $query->where('estado', $estado))
            ->when($request->numero, function ($query, $numero) {
                $query->where(function ($q) use ($numero) {
                    $q->whereHas('dbredb', fn($q2) => $q2->where('numero', $numero))
                      ->orWhereHas('dbrpadb', fn($q3) => $q3->where('numero', $numero));
                });
            })
            ->when($request->establecimiento, function ($query, $establecimiento) {
                $query->where(function ($q) use ($establecimiento) {
                    $q->whereHas('dbredb', fn($q2) => $q2->where('establecimiento', $establecimiento))
                      ->orWhereHas('dbrpadb', fn($q3) => $q3->where('establecimiento', $establecimiento));
                });
            })
            ->when($request->empresa, function ($query, $empresa) {
                $query->whereHas('dbempresa', fn($q) => $q->where('empresa', 'LIKE', "%{$empresa}%"));
            })
    
            ->orderBy('id', 'DESC')
            ->paginate(20);
    
        return view('db.tramites.index', compact('tramites'));
    }
    
    
    protected function applyZonaFilter($query, $user, $empresaId, $zonaBuscada)
    {
        if ($user->id === 4 || in_array($user->role_id, [9, 1])) {
            if ($zonaBuscada) {
                $query->whereHas('dbredb.localidad', fn($q) => $q->where('zona', $zonaBuscada))
                      ->orWhereHas('dbrpadb.localidad', fn($q) => $q->where('zona', $zonaBuscada));
            }
        } elseif ($user->role_id === 15 && $empresaId) {
            $query->where('dbempresa_id', $empresaId);
        } elseif ($user->role_id === 16) {
            // Rol 16: ver solo trámites con zona "ape" en la localidad
            $query->whereHas('dbredb.localidad', fn($q) => $q->where('zona', 'ape'));
        } elseif ($user->role_id === 17) {
            // Rol 17: ver solo trámites con zona "apcr" en la localidad
            $query->whereHas('dbredb.localidad', fn($q) => $q->where('zona', 'apcr'));
        } elseif ($user->role_id === 18) {
            // Rol 18: ver solo trámites con zona "appm" en la localidad
            $query->whereHas('dbredb.localidad', fn($q) => $q->where('zona', 'appm'));
        }
    }
    
    
    
    // Función auxiliar para obtener la zona según el rol del usuario
    private function getZonaForRole($user)
    {
        switch ($user->role_id) {
            case 9: // ID del rol DB
                return 'nc'; // Devuelve un array con ambos valores
            case 16: // ID del rol AREA ESQUEL
                return 'ape';
            case 17: // ID del rol AREA COMODORO
                return 'apcr';
            case 18: // ID del rol AREA MADRYN
                return 'appm'; // Podrías devolver 'appm' también para este caso si deseas
            default:
                return null; // Deberías manejar este caso según la lógica de tu aplicación
        }
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
    public function destroy($id)
    {
        // Encuentra el trámite por su ID
        $tramite = Dbtramite::findOrFail($id);
    
        // Verificar si el estado del trámite es "INSCRIPTO"
        if ($tramite->estado == 'INSCRIPTO') {
            $notification = 'No se puede eliminar un trámite con estado INSCRIPTO. Solo se puede dar de baja.';
            return redirect('/tramites/index')->with([
                'notification' => $notification,
                'alert_type' => 'danger'
            ]);
        }        
    
        // Eliminar todos los historiales asociados al trámite
        foreach ($tramite->historial as $historial) {
            $historial->delete();
        }
    
        // Verificar si el tipo de trámite contiene la palabra "INSCRIPCION"
        if (Str::contains($tramite->tipo_tramite, 'INSCRIPCION')) {
    
            // Si el trámite está relacionado con un establecimiento en dbredb
            if ($tramite->dbredb_id) {
                $dbredb = Dbredb::findOrFail($tramite->dbredb_id);
    
                // Verificar si el establecimiento tiene un número asignado
                if ($dbredb->numero === null) {
                    // Si no tiene número, eliminar todos los trámites y relaciones asociadas
                    Dbtramite::where('dbredb_id', $dbredb->id)->delete();
                    DB::table('dbredb_dbrubro')->where('dbredb_id', $dbredb->id)->delete();
                    Dbhistorial::where('dbredb_id', $dbredb->id)->delete();
                    $dbredb->delete();
                }
            }
    
            // Si el trámite está relacionado con un producto en dbrpadb
            if ($tramite->dbrpadb_id) {
                $dbrpadb = Dbrpadb::findOrFail($tramite->dbrpadb_id);
    
                // Verificar si el producto tiene un número asignado
                if ($dbrpadb->numero === null) {
                    // Si no tiene número, eliminar los historiales y el producto
                    Dbhistorial::where('dbrpadb_id', $dbrpadb->id)->delete();
                    $dbrpadb->delete();
                }
            }
        }
    
        // Finalmente, elimina solo el trámite actual
        $tramite->delete();
    
        $notification = 'El trámite fue ELIMINADO correctamente.';
        return redirect('/tramites/index')->with(compact('notification'));
    }
    
    
    
    
}
