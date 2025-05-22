<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    public function muestra() 
    {
    return $this->hasMany('App\Muestra');
    }//
    public function remitente() 
    {
    return $this->hasMany('App\Remitente');
    }//
    public function provincia() 
    {
    return $this->belongsTo(Provincia::class);
    }
}
