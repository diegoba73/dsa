<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public $timestamps = false;
    
    public function stockreactivos() 
    {
    return $this->hasMany('App\Stockreactivo');
    }

    public function stockinsumos() 
    {
    return $this->hasMany('App\Stockinsumos');
    }
    public function microorganismos() 
    {
    return $this->hasMany('App\Microorganismos');
    }
}
