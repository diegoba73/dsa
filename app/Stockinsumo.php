<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockinsumo extends Model
{
    public $timestamps = false;
    protected $fillable = ['fecha_entrada', 'fecha_baja', 'cantidad', 'marca', 'certificado', 'observaciones', 'almacenamiento', 'codigo_barra', 'pedido', 'registro'];

    public function insumo() 
    {
    return $this->belongsTo(Insumo::class);
    }

    public function proveedor() 
    {
    return $this->belongsTo(Proveedor::class);
    }
}
