<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dsaexpediente extends Model
{
    protected $table = 'dsaexpedientes';

    public $timestamps = true;

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }    

    public function departamento() 
    {
    return $this->belongsTo(Departamento::class);
    }

    public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function scopeNro_expediente($query, $nro_expediente)
    {
        if($nro_expediente)
        return $query->where('nro_expediente', 'LIKE', "$nro_expediente");
    }

    public function scopeNro_nota($query, $nro_nota)
    {
        if($nro_nota)
        return $query->where('nro_nota', 'LIKE', "$nro_nota");
    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }
}
