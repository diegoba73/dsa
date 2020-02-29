<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipomuestra extends Model
{
    public function matriz() 
    {
    return $this->belongsTo(Matriz::class);
    }
    public function muestras() 
    {
    return $this->hasMany('App\Muestra');
    }
}
