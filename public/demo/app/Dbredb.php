<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbredb extends Model
{

    public function rubros()
    {
        return $this->belongsToMany(Dbrubro::class, 'dbredb_dbrubro')->withPivot('dbcategoria_id', 'actividad');
    }
    public function dbcategoria() 
    {
    return $this->belongsTo(Dbcategoria::class);
    }
    public function expediente()
    {
        return $this->belongsTo(Dbexp::class, 'dbexp_id');
    }
    public function scopeNumero($query, $numero)
    {
        if($numero)
        return $query->where('numero', 'LIKE', "$numero");
    }

    public function scopeRazon($query, $razon)
    {
        if($razon)
        return $query->where('razon', 'LIKE', "%$razon%");
    }
}
