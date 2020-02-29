<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockreactivo extends Model
{
    public $timestamps = false;
    protected $fillable = ['fecha_entrada', 'fecha_apertura', 'fecha_vencimiento', 'fecha_baja', 'contenido', 'marca', 'grado', 'lote', 'conservacion', 'almacenamiento', 'hs', 'observaciones', 'codigo_barra', 'reactivo_id', 'proveedor_id', 'pedido', 'registro'];

    public function reactivo() 
    {
    return $this->belongsTo(Reactivo::class);
    }
    public function proveedor() 
    {
    return $this->belongsTo(Proveedor::class);
    }
}
