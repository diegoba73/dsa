<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Translate\TranslateClient;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TraductorController extends Controller
{
    public function traducir($texto, $idioma_destino)
    {
        // Crear una nueva instancia de GoogleTranslate
        $tr = new GoogleTranslate();
        
        // Establecer el idioma de origen y el idioma de destino
        $tr->setSource('es');
        $tr->setTarget($idioma_destino);
        
        // Traducir el texto
        $texto_traducido = $tr->translate($texto);
        
        // Devolver la traducción
        return $texto_traducido;
    }
}
