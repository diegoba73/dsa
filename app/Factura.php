<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function dbtramite()
    {
        return $this->hasOne(Dbtramite::class, 'factura_id');
    }

    public function remitente() 
    {
        return $this->belongsTo(Remitente::class, 'remitentes_id');
    }

    public function user() 
    {
    return $this->belongsTo(User::class, 'users_id');
    }

    public function ensayos()
    {
        return $this->hasManyThrough(Ensayo::class, Muestra::class);
    }

    public function departamento()
    {
        return $this->belongsTo('App\Departamento', 'departamento_id', 'id');
    }

    public function nomencladors()
    {
        return $this->belongsToMany(Nomenclador::class)->withPivot('cantidad', 'subtotal');
    }  
    
    // Relación indirecta a través de User y Empresa para obtener los Dbredb
    public function redbs()
    {
        return $this->hasManyThrough(
            Dbredb::class,
            Dbempresa::class,
            'user_id', // Llave foránea en Empresa (user_id)
            'dbempresa_id', // Llave foránea en Dbredb (dbempresa_id)
            'users_id', // Llave local en Factura (users_id)
            'id' // Llave primaria en Empresa (id)
        );
    }

    public function scopeNumero($query, $numero)
    {
        if($numero)
        return $query->where('id', 'LIKE', "$numero");
    }

    public function scopeRemitente($query, $remitente)
    {
        if($remitente)
            return $query->where('remitentes_id', 'LIKE', "$remitente");
    }

    public function scopeDepartamento($query, $departamento)
    {
        if($departamento)
        return $query->where('departamento_id', 'LIKE', "%$departamento%");
    }

    public function scopeFechaPagoRango($query, $fechaPagoInicio, $fechaPagoFinal)
    {
        if ($fechaPagoInicio && $fechaPagoFinal) {
            return $query->whereBetween('fecha_pago', [$fechaPagoInicio, $fechaPagoFinal]);
        }
    }
    
    public function scopeFechaEmisionRango($query, $fechaEmisionInicio, $fechaEmisionFinal)
    {
        if ($fechaEmisionInicio && $fechaEmisionFinal) {
            return $query->whereBetween('fecha_emision', [$fechaEmisionInicio, $fechaEmisionFinal]);
        }
    }
}
