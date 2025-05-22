<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomenclador extends Model
{
    public $timestamps = false;

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }

}
