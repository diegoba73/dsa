<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';

    public $timestamps = false;

    public function pedido() 
    {
    return $this->belongsTo(Pedido::class);
    }

}
