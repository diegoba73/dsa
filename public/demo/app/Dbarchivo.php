<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbarchivo extends Model
{
    public $timestamps = false;

	public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function scopeCaja($query, $caja)
    {
        if($caja)
        return $query->where('caja', 'LIKE', "$caja");
    }

    public function scopeEstablecimiento($query, $establecimiento)
    {
        if($establecimiento)
        return $query->where('establecimiento', 'LIKE', "%$establecimiento%");
    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion)
        return $query->where('descripcion', 'LIKE', "%$descripcion%");
    }}
