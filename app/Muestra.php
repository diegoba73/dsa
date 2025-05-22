<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    protected $fillable = [
        'revisada', // Agrega revisada a la lista blanca fillable
        'condicion',
    ];

    public function localidad() 
    {
    return $this->belongsTo(Localidad::class);
    }
    public function provincia() 
    {
    return $this->belongsTo(Provincia::class);
    }
    public function solicitante() 
    {
    return $this->belongsTo(Solicitante::class);
    }
	public function remitente() 
    {
    return $this->belongsTo(Remitente::class);
    }
    public function departamento() 
    {
    return $this->belongsTo(Departamento::class);
    }
    public function matriz() 
    {
    return $this->belongsTo(Matriz::class);
    }
    public function tipomuestra() 
    {
    return $this->belongsTo(Tipomuestra::class);
    }
    public function user() 
    {
    return $this->belongsTo(User::class);
    }
    public function ensayos()
    {
        return $this->belongsToMany('App\Ensayo')->withPivot('fecha_inicio', 'fecha_fin', 'resultado');
    }

    public function dbremitos()
    {
        return $this->belongsToMany('App\Dbremito');
    }

    public function dsbremitos()
    {
        return $this->belongsToMany('App\Dsbremito');
    }

    public function dsoremitos()
    {
        return $this->belongsToMany('App\Dsoremito');
    }

    public function analitos() 
    {
    return $this->hasMany('App\Analito');
    }


    public function factura() 
    {
        return $this->belongsTo(Factura::class);
    }
    public function scopeId($query, $id)
    {
        return $id ? $query->where('id', $id) : $query;
    }
    
    public function scopeNumero($query, $numero)
    {
        return $numero ? $query->where('numero', $numero) : $query;
    }
    
    public function scopeTipoMuestra($query, $tipo_muestra)
    {
        return $tipo_muestra ? $query->where('tipo_muestra', 'LIKE', "%$tipo_muestra%") : $query;
    }
    
    public function scopeMuestra($query, $muestra)
    {
        return $muestra ? $query->where('muestra', 'LIKE', "%$muestra%") : $query;
    }
    
    public function scopeLugarExtraccion($query, $lugar_extraccion)
    {
        return $lugar_extraccion ? $query->where('lugar_extraccion', 'LIKE', "%$lugar_extraccion%") : $query;
    }
    
    public function scopeIdentificacion($query, $identificacion)
    {
        return $identificacion ? $query->where('identificacion', 'LIKE', "%$identificacion%") : $query;
    }
    
    public function scopeLote($query, $lote)
    {
        return $lote ? $query->where('lote', 'LIKE', "%$lote%") : $query;
    }
    
    public function scopeRemitente($query, $remitente_id)
    {
        return $remitente_id ? $query->where('remitente_id', $remitente_id) : $query;
    }
    
    public function scopeDepartamento($query, $departamento_id)
    {
        return $departamento_id ? $query->where('departamento_id', $departamento_id) : $query;
    }
    
    public function scopePendiente($query, $pendiente)
    {
        if ($pendiente) {
            return $query->where('cargada', 0)->where('aceptada', 1);
        }
        return $query;
    }
    
    public function scopeCromatografia($query, $cromatografia)
    {
        return $cromatografia ? $query->where('cromatografia', 1) : $query;
    }
    
    public function scopeQuimica($query, $quimica)
    {
        return $quimica ? $query->where('quimica', 1) : $query;
    }
    
    public function scopeEnsayoBiologico($query, $ensayo_biologico)
    {
        return $ensayo_biologico ? $query->where('ensayo_biologico', 1) : $query;
    }
    
    public function scopeMicrobiologia($query, $microbiologia)
    {
        return $microbiologia ? $query->where('microbiologia', 1) : $query;
    }
    
    public function scopeCargada($query, $cargada)
    {
        if ($cargada == 1) {
            return $query->where('cargada', true)
                         ->whereNull('revisada');
        } elseif ($cargada == 0) {
            return $query->where(function ($q) {
                $q->whereNull('fecha_salida')
                  ->orWhere('fecha_salida', '>', now());
            });
        }
        return $query;
    }
    
    public function scopeFechaEntradaInicio($query, $fecha_inicio)
    {
        return $fecha_inicio ? $query->whereDate('fecha_entrada', '>=', $fecha_inicio) : $query;
    }
    
    public function scopeFechaEntradaFinal($query, $fecha_final)
    {
        return $fecha_final ? $query->whereDate('fecha_entrada', '<=', $fecha_final) : $query;
    }

    public function scopeFactura($query, $estado)
    {
        if (!isset($estado)) {
            return $query;
        }
    
        if ($estado === '1') {
            return $query->where('factura_id', '>', 0);
        }
    
        if ($estado === '0') {
            return $query->where('factura_id', 0)
                         ->where(function ($q) {
                             $q->whereNull('tipo_prestacion')
                               ->orWhereRaw("LOWER(TRIM(tipo_prestacion)) != 'aps'");
                         });
        }
    
        return $query;
    }
    

//
}
