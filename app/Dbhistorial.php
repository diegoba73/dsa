<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbhistorial extends Model
{
    protected $fillable = [
        'fecha',
        'area',
        'motivo',
        'observaciones',
        'user_id',
        'dbempresa_id',
        'dbtramite_id',
        // si usás también dbredb_id, agregalo acá
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dbempresa()
    {
        return $this->belongsTo(Dbempresa::class, 'dbempresa_id');
    }

    public function redb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredb_id');
    }
    
    public function rpadb()
    {
        return $this->belongsTo(Dbrpadb::class, 'dbrpadb_id');
    }

    public function scopeRazon($query, $razon)
    {
        if($razon)
        return $query->where('razon', 'LIKE', "%$razon%");
    }

    public function scopeEstado($query, $estado)
    {
        if($estado)
        return $query->where('estado', 'LIKE', "%$estado%");
    }
}
