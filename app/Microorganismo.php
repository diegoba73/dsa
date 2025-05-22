<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microorganismo extends Model
{
    protected $table = 'microorganismos';

    public $timestamps = false;

    public function cepas() 
    {
    return $this->hasMany('App\Cepa');
    }//
    public function proveedor() 
    {
    return $this->belongsTo(Proveedor::class);
    }//
    public function user() 
    {
    return $this->belongsTo(User::class);
    }

}
