<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Translate\TranslateClient;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TraductorController extends Controller
{
    // Array de traducciones manuales
    protected $traducciones = [
        "Sulfitos totales en langostinos" => "Total Sulfites in prawns",
        "Fecha de elaboración" => "Production date",
        "Fecha de vencimiento" => "Expiry date",
        "Matriz" => "Matrix",
        "Identificación" => "Identification",
        "Muestra" => "Sample",
        "Tipo" => "Type",
        "Fecha de entrada" => "Date of entrance",
        "Fecha de extracción" => "Date of collection",
        "Hora Extracción" => "Extraction Time",
        "Lugar de extracción" => "Place of collection",
        "Localidad" => "City",
        "Provincia" => "Province",
        "Unidades" => "Units",
        "Peso / Volumen" => "Weight / Volume",
        "Elaborado por" => "Produced by",
        "Domicilio" => "Producer’s address",
        "Marca" => "Mark",
        "Registro de establecimiento nro" => "Establishment register nbr",
        "Registro de producto" => "Product register",
        "Lote nro" => "Lot nbr",
        "Cantidad" => "Quantity",
        "Partida" => "Shipment",
        "Destino" => "Destination",
        "Fecha de inicio" => "Beginning date",
        "Fecha de fin" => "Ending date",
        "Ensayo" => "Essay",
        "Norma / Procedimiento" => "Method",
        "Resultado" => "Result",
        "Unidades" => "Units",
        "Observaciones" => "Observations",
        "Solicitante" => "Applicant",
        "Dirección del solicitante" => "Applicant’s address",
        "Remitente" => "Sender",
        "Realizado el muestreo por" => "Sampling performed by",
        "ND: No detectable" => "ND: Not Detectable",
        "Los resultados informados se refieren exclusivamente a la muestra recibida y el Laboratorio declina toda responsabilidad por cualquier uso indebido de este informe. Este certificado solo podrá ser reproducido en su totalidad y únicamente con la autorización escrita del Laboratorio." => "The results reported refer exclusively to the sample received and the Laboratory declines all responsibility for any improper use of this report. This certificate may only be reproduced in its entirety and only with the written authorization of the Laboratory.",
        "Berwyn 226, Trelew - Chubut, Argentina - Tel.:(+54) 280 4427421/4421011 - Email:laboratoriodpsachubut@gmail.com" => "Berwyn 226, Trelew - Chubut, Argentina - Tel.:(+54) 280 4427421/4421011 - Email:laboratoriodpsachubut@gmail.com",
        // ... Agrega más traducciones aquí ...
    ];

    // Cache de traducciones dinámicas para mejorar el rendimiento
    protected static $cache = [];

    public function traducir($texto, $idioma)
    {
        if (empty($texto)) return '';

        $claveNormalizada = $this->normalizarTexto($texto);

        // 1. Buscar en traducciones manuales (también normalizadas)
        foreach ($this->traducciones as $original => $traduccion) {
            if ($this->normalizarTexto($original) === $claveNormalizada) {
                return $traduccion;
            }
        }

        // 2. Verificar si ya fue traducido antes (cache en memoria para esta ejecución)
        $cacheKey = $idioma . ':' . $claveNormalizada;
        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        // 3. Traducir automáticamente
        try {
            $traductor = new GoogleTranslate();
            $traductor->setSource('es');
            $traductor->setTarget($idioma);
            $traduccion = $traductor->translate($texto);

            // Guardar en cache interna
            self::$cache[$cacheKey] = $traduccion;

            return $traduccion;
        } catch (\Exception $e) {
            // Manejo básico de errores
            \Log::error('Error al traducir: ' . $e->getMessage());
            return $texto; // Devuelve el texto original si falla
        }
    }

    protected function normalizarTexto($texto)
    {
        return trim(mb_strtolower($texto));
    }
}
