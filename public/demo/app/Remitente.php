<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remitente extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        // ... tus otros campos ...
        'user_id',
    ];

    public function muestras() 
    {
    return $this->hasMany('App\Muestra');
    }
    public function dsoremitos() 
    {
    return $this->hasMany('App\Dsoremito');
    }
    public function dsbremitos() 
    {
    return $this->hasMany('App\Dsbremito');
    }
    public function dbremitos() 
    {
    return $this->hasMany('App\Dbremito');
    }
    public function localidad() 
    {
    return $this->belongsTo(Localidad::class);
    }
    public function scopeRemitente($query, $remitente)
    {
        if($remitente)
        return $query->where('nombre', 'LIKE', "%$remitente%");
    }

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
