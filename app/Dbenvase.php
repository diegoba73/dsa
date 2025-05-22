<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbenvase extends Model
{
    //
    protected $fillable = [
        'tipo_envase',
        'material',
        'contenido_neto',
        'contenido_escurrido',
        'lapso_aptitud',
        'condiciones_conservacion',
        'ruta_cert_envase',
        'ruta_rotulo_envase',
        'dbrpadb_id'
    ];    
}
