<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbcategoria extends Model
{
    public function dbrubro() 
    {
    return $this->hasMany(Dbrubro::class);
    }
    public function dbredb() 
    {
    return $this->hasMany('App\Dbredb');
    }
}
