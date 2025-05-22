<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    public $timestamps = false;

    public function reactivos()
    {
        return $this->belongsToMany(Reactivo::class)->withPivot('cantidad_pedida', 'cantidad_entregada', 'costo_total', 'observaciones', 'aceptado');
    }

    public function insumos()
    {
        return $this->belongsToMany('App\Insumo')->withPivot('cantidad_pedida', 'cantidad_entregada', 'observaciones', 'aceptado');
    }

    public function departamento() 
    {
    return $this->belongsTo(Departamento::class);
    }

    public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function articulos() 
    {
    return $this->hasMany(Articulo::class);
    }

    public function scopeNro_pedido($query, $nro_pedido)
    {
        if($nro_pedido)
        return $query->where('nro_pedido', 'LIKE', "$nro_pedido");
    }

    public function scopeNro_nota($query, $nro_nota)
    {
        if($nro_nota)
        return $query->where('nro_nota', 'LIKE', "$nro_nota");
    }
    
    public function scopeNro_expediente($query, $nro_expediente)
    {
        if($nro_expediente)
        return $query->where('nro_expediente', 'LIKE', "%$nro_expediente%");
    }

    public function scopeDpto($query, $dpto)
    {
        if($dpto)
        return $query->where('departamento_id', 'LIKE', "$dpto");
    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }
}
