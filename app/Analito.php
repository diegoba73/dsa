<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analito extends Model
{
    public $timestamps = false;
    protected $fillable = ['analito', 'valor_hallado', 'unidad', 'parametro_calidad'];

    public function muestra() 
    {
    return $this->belongsTo(Muestra::class);
    }
}
