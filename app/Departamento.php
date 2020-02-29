<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public function muestras() 
    {
    return $this->hasMany('App\Muestra');
    }
    public function user() 
    {
    return $this->belongsTo('App\User');
    }

    public function pedidos() 
    {
    return $this->hasMany('App\Pedido');
    }
}
