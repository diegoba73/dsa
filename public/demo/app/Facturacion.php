<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    public $timestamps = false;

	public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function scopeDepositante($query, $depositante)
    {
        if($depositante)
        return $query->where('depositante', 'LIKE', "%$depositante%");
    }

    public function scopeFechaE($query, $fecha_e)
    {
        if($fecha_e)
        return $query->where('fecha_emision', 'LIKE', "%$fecha_e%");
    }

    public function scopeFechaP($query, $fecha_p)
    {
        if($fecha_p)
        return $query->where('fecha_pago', 'LIKE', "%$fecha_p%");
    }

    public function scopeDetalle($query, $detalle)
    {
        if($detalle)
        return $query->where('detalle', 'LIKE', "%$detalle%");
    }

    public function scopeDepartamento($query, $departamento)
    {
        if($departamento)
        return $query->where('departamento', 'LIKE', "%$departamento%");
    }
}
