<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    

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

    public function scopeId($query, $id)
    {
        if($id)
        return $query->where('id', 'LIKE', "$id");
    }
    
    public function scopeNumero($query, $numero)
    {
        if($numero)
        return $query->where('numero', 'LIKE', "$numero");
    }

    public function scopeTipo($query, $tipo_muestra)
    {
        if($tipo_muestra)
        return $query->where('tipo_muestra', 'LIKE', "%$tipo_muestra%");
    }

    public function scopeMuestra($query, $muestra)
    {
        if($muestra)
        return $query->where('muestra', 'LIKE', "%$muestra%");
    }

    public function scopeLugar($query, $lugar)
    {
        if($lugar)
        return $query->where('lugar_extraccion', 'LIKE', "%$lugar%");
    }

    public function scopeRemite($query, $remitente)
    {
        if($remitente)
        return $query->where('remitente_id', 'LIKE', "%$remitente%");
    }
    public function scopeDepartamento($query, $departamento)
    {
        if($departamento)
        return $query->where('departamento_id', 'LIKE', "%$departamento%");
    }

    public function scopePendiente($query, $pendiente)
    {
        if($pendiente)

        return $query->where('cargada', 0)->where('aceptada', 1);
    }

    public function scopeCromatografia($query, $cromatografia)
    {
        if($cromatografia)

        return $query->where('cromatografia', 1);
    }

    public function scopeQuimica($query, $quimica)
    {
        if($quimica)

        return $query->where('quimica', 1);
    }

    public function scopeEnsayo($query, $ensayo_biologico)
    {
        if($ensayo_biologico)

        return $query->where('ensayo_biologico', 1);
    }

    public function scopeMicrobiologia($query, $microbiologia)
    {
        if($microbiologia)

        return $query->where('microbiologia', 1);
    }

//
}
