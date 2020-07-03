<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Ensayo;
use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DlExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return DB::table('ensayo_muestra')->join('muestras','ensayo_muestra.muestra_id', '=', 'muestras.id')->join('ensayos','ensayo_muestra.ensayo_id', '=', 'ensayos.id')->join('departamentos','muestras.departamento_id', '=', 'departamentos.id')->join('remitentes','muestras.remitente_id', '=', 'remitentes.id')->join('provincias','muestras.provincia_id', '=', 'provincias.id')->join('localidads','muestras.localidad_id', '=', 'localidads.id')->select("muestras.numero", "departamentos.departamento", "muestras.tipo_prestacion", "muestras.entrada", "muestras.muestra", "remitentes.nombre", "muestras.solicitante", DB::raw("DATE_FORMAT(muestras.fecha_entrada, '%d-%c-%Y')"), DB::raw("DATE_FORMAT(muestras.fecha_extraccion, '%d-%c-%Y')"), "muestras.identificacion", "muestras.lugar_extraccion", "localidads.localidad", "provincias.provincia", "ensayos.tipo_ensayo", "ensayos.ensayo", "ensayo_muestra.resultado", "ensayos.unidades")->where('muestras.departamento_id', 1)->get();


    }

    public function headings(): array
    {
        return [
            'Número',
            'Departamento',
            'Tipo Prestación',
            'Tipo Entrada',
            'Muestra',
            'Remite',
            'Solicitante',
            'Fecha de Entrada',
            'Fecha de Extracción',
            'Identificación',
            'Lugar de Extracción',
            'Localidad',
            'Provincia',
            'Área',
            'Ensayo',
            'Resultado',
            'Unidades',
        ];
    }

}


