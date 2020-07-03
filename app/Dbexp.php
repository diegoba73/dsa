<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbexp extends Model
{
    public $timestamps = false;

	public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function scopeNumero($query, $numero)
    {
        if($numero)
        return $query->where('numero', 'LIKE', "$numero");
    }

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        return $query->where('fecha', 'LIKE', "%$fecha%");
    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }
}
