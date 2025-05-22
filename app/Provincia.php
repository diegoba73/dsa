<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    public function localidad() 
    {
    return $this->hasMany('App\Localidad');
    }//
    public function muestra() 
    {
    return $this->hasMany('App\Muestra');
    }//
}
