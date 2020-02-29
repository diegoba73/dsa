<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dsoremito extends Model
{
    public function muestras()
    {
        return $this->belongsToMany('App\Muestra');
    }

    public function remitente() 
    {
    return $this->belongsTo(Remitente::class);
    }

    public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public $timestamps = false;

    public function scopeNro_nota($query, $nro_nota)
    {
        if($nro_nota)
        return $query->where('nro_nota', 'LIKE', "$nro_nota");
    }

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        return $query->where('fecha', 'LIKE', "%$fecha%");
    }

    public function scopeConclusion($query, $conclusion)
    {
        if($conclusion)
        return $query->where('conclusion', 'LIKE', "%$conclusion%");
    }
    public function scopeRemite($query, $remitente)
    {
        if($remitente)
        return $query->where('remitente_id', 'LIKE', "%$remitente%");
    }
}
