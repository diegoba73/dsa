<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbtramite extends Model
{
    protected $fillable = [
        'fecha_inicio', 'tipo_tramite', 'estado', 'finalizado', 'dbempresa_id', 'dbredb_id', 'dbrpadb_id', 'dbexp_id'
    ];

    // Estados posibles
    const ESTADOS = [
        'INICIADO',
        'EN_REVISION_AREA_PROGRAMATICA',
        'APROBADO_AREA_PROGRAMATICA',
        'EN_REVISION_NIVEL_CENTRAL',
        'APROBADO_NIVEL_CENTRAL',
        'PARA_INSCRIPCION',
        'INSCRIPTO'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dbempresa()
    {
        return $this->belongsTo(Dbempresa::class, 'dbempresa_id')->withDefault();
    }

    public function dbredb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id')->withDefault();
    }
    
    public function dbrpadb()
    {
        return $this->belongsTo(Dbrpadb::class, 'dbrpadb_id')->withDefault();
    }

    public function historial()
    {
        return $this->hasMany(Dbhistorial::class, 'dbtramite_id');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    public function dbexp()
    {
        return $this->belongsTo(Dbexp::class);
    }
    
    // Scope para filtrar por el nombre del establecimiento
    public function scopeEstablecimiento($query, $establecimiento)
    {
        if ($establecimiento) {
            return $query->whereHas('dbredb', function ($query) use ($establecimiento) {
                $query->where('establecimiento', 'like', '%' . $establecimiento . '%');
            });
        }
        return $query;
    }

    public function scopeEmpresa($query, $empresa)
    {
        if ($empresa) {
            return $query->whereHas('dbempresa', function ($query) use ($empresa) {
                $query->where('empresa', 'like', '%' . $empresa . '%');
            });
        }
        return $query;
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopeRpadb($query, $redb)
    {
        if($rpadb)
        return $query->where('dbpadb_id', 'LIKE', "%$rpadb%");
    }

    
}
