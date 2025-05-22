<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ensayo;
use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;



class ClienteExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $writerType = Excel::XLSX;

    protected $year;
    protected $userId;

    public function __construct($year, $userId)
    {
        $this->year = $year;
        $this->userId = $userId;
    }

    public function collection()
    {

        $year = $this->year;
        $userId = $this->userId;
        return DB::table('ensayo_muestra')
        ->join('muestras','ensayo_muestra.muestra_id', '=', 'muestras.id')
        ->join('ensayos','ensayo_muestra.ensayo_id', '=', 'ensayos.id')
        ->join('departamentos','muestras.departamento_id', '=', 'departamentos.id')
        ->join('remitentes','muestras.remitente_id', '=', 'remitentes.id')
        ->join('provincias','muestras.provincia_id', '=', 'provincias.id')
        ->join('localidads','muestras.localidad_id', '=', 'localidads.id')
        ->select(
            "muestras.numero",
            "departamentos.departamento",
            "muestras.tipo_prestacion",
            "muestras.entrada",
            "muestras.muestra",
            "remitentes.nombre",
            "muestras.solicitante",
            DB::raw("DATE_FORMAT(muestras.fecha_entrada, '%d-%c-%Y')"),
            DB::raw("DATE_FORMAT(muestras.fecha_extraccion, '%d-%c-%Y')"),
            "muestras.identificacion",
            "muestras.lugar_extraccion",
            "muestras.lote",
            "localidads.localidad",
            "provincias.provincia",
            "ensayos.tipo_ensayo",
            "ensayos.ensayo",
            "ensayo_muestra.resultado",
            "ensayos.unidades")
        ->where('muestras.fecha_entrada', '>=', date("$year-01-01"))
        ->where('muestras.fecha_entrada', '<=', date("$year-12-31"))
        ->where('muestras.remitente_id', $userId)
        ->get();

    }

    public function headings(): array
    {
        return [
            'Número',
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
            'Ensayo',
            'Resultado',
            'Unidades',
        ];
    }

}


