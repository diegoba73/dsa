<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbdt extends Model
{
    protected $fillable = [
        'nombre', 'dni', 'titulo', 'domicilio', 'ciudad', 'telefono', 
        'email', 'universidad', 'matricula', 'fecha_inscripcion', 'fecha_reinscripcion', 'fecha_baja', 'motivo_baja', 'ruta_dni', 'ruta_titulo', 
        'ruta_cv', 'ruta_cert_domicilio', 'ruta_antecedentes', 'ruta_arancel', 'ruta_foto'
    ];
    public function redbs()
    {
        return $this->hasMany(Dbredb::class, 'dbdt_id');
    }
    public function scopeDni($query, $dni)
    {
        if($dni)
        return $query->where('dni', 'LIKE', "$dni");
    }
    public function scopeNombre($query, $nombre)
    {
        if($nombre)
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }
}
