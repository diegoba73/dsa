<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbbaja extends Model
{
    protected $casts = [
        'fecha_baja' => 'date', // Esto asegura que se convierta en Carbon automáticamente
    ];

    protected $fillable = [
        'fecha_baja', 'caja', 'motivo', 'expediente', 
        'nro_establecimiento', 'establecimiento', 'solicito',
        'dbredb_id', 'dbrpadb_id'
    ];

    // Relación con Dbredb
    public function redb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id');
    }

    // Relación con Dbrpadb
    public function rpadb()
    {
        return $this->belongsTo(Dbrpadb::class, 'dbrpadb_id');
    }
    
	public function user() 
    {
    return $this->belongsTo(User::class);
    }

    public function scopeNro_registro($query, $nro_registro)
    {
        if($nro_registro)
        return $query->where('nro_registro', 'LIKE', "$nro_registro");
    }

    public function scopeEstablecimiento($query, $establecimiento)
    {
        if($establecimiento)
        return $query->where('establecimiento', 'LIKE', "%$establecimiento%");
    }
}
