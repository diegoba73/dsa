<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbredb extends Model
{

    public function empresa()
    {
        return $this->belongsTo(Dbempresa::class, 'dbempresa_id');
    }
    public function dbrpadbs()
    {
        return $this->hasMany(Dbrpadb::class, 'dbredb_id');
    }
    public function localidad() 
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }
    public function rubros()
    {
        return $this->belongsToMany(Dbrubro::class, 'dbredb_dbrubro', 'dbredb_id', 'dbrubro_id')
                    ->withPivot('id', 'dbcategoria_id', 'actividad');
    }    
    public function dbcategoria()
    {
        return $this->belongsTo(Dbcategoria::class, 'dbcategoria_id');
    }
    public function expediente()
    {
        return $this->belongsTo(Dbexp::class, 'dbredb_id');
    }
    public function dbtramites()
    {
        return $this->hasMany(Dbtramite::class, 'dbredb_id');
    }
    public function inspecciones()
    {
        return $this->hasMany(Dbinspeccion::class, 'dbredb_id');
    }
    public function historial()
    {
        return $this->hasMany(Dbhistorial::class, 'dbredb_id');
    }
    public function baja()
    {
        return $this->belongsTo(Dbbaja::class, 'dbbaja_id');
    }
    public function dt()
    {
        return $this->belongsTo(Dbdt::class, 'dbdt_id');
    }
    public function scopeNumero($query, $numero)
    {
        if ($numero) {
            return $query->where('numero', '=', $numero); // Usando '=' para coincidencia exacta
        }
    
        return $query;
    }

    public function scopeEstablecimiento($query, $establecimiento)
    {
        if($establecimiento)
        return $query->where('establecimiento', 'LIKE', "%$establecimiento%");
    }

    public function scopeFinalizado($query, $finalizado = true)
    {
        return $query->where('finalizado', $finalizado);
    }
    
    public function scopeByEmpresa($query, $empresaId)
    {
        if ($empresaId) {
            return $query->where('dbempresa_id', $empresaId);
        }
        return $query;
    }

    public function scopeZona($query, $zona)
    {
        if ($zona) {
            return $query->whereHas('localidad', function ($query) use ($zona) {
                $query->where('zona', $zona);
            });
        }
        return $query;
    }
}
