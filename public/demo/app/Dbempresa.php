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
}
