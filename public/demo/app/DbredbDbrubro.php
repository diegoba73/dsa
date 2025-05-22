<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DbredbDbrubro extends Model
{
    protected $fillable = [
        'dbredbs_id', 'dbrubros_id', 'dbcategorias_id', 'actividad'
        // Otros campos si los hay
    ];

    // Definir la relación con la tabla principal (dbredb)
    public function redb()
    {
        return $this->belongsTo(Dbredb::class, 'dbredbs_id', 'id');
    }
    public function categoria() 
    {
    return $this->belongsTo(Dbcategoria::class);
    }
    
    // Otras relaciones si es necesario
}
