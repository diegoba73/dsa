<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matriz extends Model
{
    public function muestras() 
    {
    return $this->hasMany('App\Muestra');
    }
    public function ensayos() 
    {
    return $this->hasMany('App\Ensayo');
    }
    public function Tipomuestra() 
    {
    return $this->hasMany('App\Tipomuestra');
    }//
}
