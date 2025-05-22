<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbrpadb extends Model
{
    protected $fillable = [
        'denominacion',
        'nombre_fantasia',
        'marca',
        'dbredb_dbrubro_id',
        'articulo_caa',
        // Añade todos los otros campos que necesitas asignar masivamente
    ];
    public function dbempresa()
    {
        return $this->belongsTo(Dbempresa::class, 'dbempresa_id', 'id');
    }
    public function dbredb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id');
    }
    public function dbtramites()
    {
        return $this->hasMany(Dbtramite::class, 'dbrpadb_id');
    }
    public function envases()
    {
        return $this->hasMany(Dbenvase::class, 'dbrpadb_id');
    }

    public function baja()
    {
        return $this->belongsTo(Dbbaja::class, 'dbbaja_id');
    }

    public function tramiteActivo($tipo = 'BAJA PRODUCTO')
    {
        return $this->tramites()
            ->where('tipo_tramite', $tipo)
            ->where('finalizado', false)
            ->latest()
            ->first();
    }


    public function tramites()
    {
        return $this->hasMany(Dbtramite::class, 'dbrpadb_id');
    }

    public function dbbaja()
    {
        return $this->belongsTo(Dbbaja::class, 'dbbaja_id');
    }
    
    public function scopeNumero($query, $numero)
    {
        if ($numero) {
            return $query->where('numero', 'LIKE', "$numero");
        }
    }

    public function scopeDenominacion($query, $denominacion)
    {
        if ($denominacion) {
            return $query->where('denominacion', 'LIKE', "%$denominacion%");
        }
    }

    public function scopeMarca($query, $marca)
    {
        if ($marca) {
            return $query->where('marca', 'LIKE', "%$marca%");
        }
    }
}

