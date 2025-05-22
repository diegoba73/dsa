<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DbenvaseController extends Controller
{
    protected $fillable = [
        'tipo_envase',
        'material',
        'contenido_neto',
        'contenido_escurrido',
        'lapso_aptitud',
        'condiciones_conservacion',
        'ruta_cert_envase',
        'ruta_rotulo',  // <- Este es clave si usas update()
    ];
    
}
