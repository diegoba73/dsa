<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesaentrada extends Model
{

    public $timestamps = false;

    public function scopeFecha($query, $fecha_ingreso)
    {
        if($fecha_ingreso)
        return $query->where('fecha_ingreso', 'LIKE', "$fecha_ingreso");
    }
    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }
    public function scopeDestino($query, $destino)
    {
        if($destino)
        return $query->where('destino', 'LIKE', "%$destino%");
    }
    public function scopeNota($query, $nro_nota_remitida)
    {
        if($nro_nota_remitida)
        return $query->where('nro_nota_remitida', 'LIKE', "%$nro_nota_remitida%");
    }
}
