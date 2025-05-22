<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbrubro extends Model
{
    public function dbredbs()
    {
        return $this->belongsToMany(Dbredb::class, 'dbredb_dbrubro')
        ->withPivot('dbcategoria_id', 'actividad');
    }
    public function dbcategoria() 
    {
        return $this->belongsTo(Dbcategoria::class);
    }//
    public function categorias()
    {
        return $this->belongsTo(Dbcategoria::class, 'dbcategoria_id');
    }
}
