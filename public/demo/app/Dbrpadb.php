<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbrpadb extends Model
{
    public function redb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id');
    }
    
    public function scopeNumero($query, $numero)
    {
        if($numero)
        return $query->where('numero', 'LIKE', "$numero");
    }

    public function scopeDenominacion($query, $denominacion)
    {
        if($denominacion)
        return $query->where('denominacion', 'LIKE', "%$denominacion%");
    }

    public function scopeMarca($query, $marca)
    {
        if($marca)
        return $query->where('marca', 'LIKE', "%$marca%");
    }
}
