<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbinspeccion extends Model
{
    public function scopeRazon($query, $razon)
    {
        if($razon)
        return $query->where('razon', 'LIKE', "%$razon%");
    }

    public function scopeDireccion($query, $direccion)
    {
        if($direccion)
        return $query->where('direccion', 'LIKE', "%$direccion%");
    }

    public function scopeDbredb($query, $dbredb)
    {
        if($dbredb)
        return $query->where('dbredb_id', 'LIKE', "%$dbredb%");
    }
}
