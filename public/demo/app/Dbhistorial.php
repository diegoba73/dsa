<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbhistorial extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dbempresa()
    {
        return $this->belongsTo(Dbempresa::class, 'dbempresa_id');
    }

    public function redb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id');
    }
    
    public function rpadb()
    {
        return $this->belongsTo(Dbrpadb::class, 'dbrpadb_id');
    }

    public function scopeRazon($query, $razon)
    {
        if($razon)
        return $query->where('razon', 'LIKE', "%$razon%");
    }

    public function scopeEstado($query, $estado)
    {
        if($estado)
        return $query->where('estado', 'LIKE', "%$estado%");
    }

    public function scopeDbempresa($query, $dbempresa)
    {
        if($dbempresa)
        return $query->where('dbempresa_id', 'LIKE', "%$dbempresa%");
    }
}
