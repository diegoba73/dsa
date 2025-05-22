<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbempresa extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function expediente() 
    {
    return $this->belongsTo(Dbexp::class);
    }
    public function scopeEmpresa($query, $empresa)
    {
        if($empresa)
        return $query->where('empresa', 'LIKE', "%$empresa%");
    }
    
    public function dbredbs()
    {
        return $this->hasMany(Dbredb::class, 'dbempresa_id');
    }
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function provincia()
    {
        return $this->localidad->provincia(); // si va a través de la localidad
    }
}
