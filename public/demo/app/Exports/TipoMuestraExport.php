<?php

namespace App\Exports;

use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TipoMuestraExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tiposMuestra;

    public function __construct($tiposMuestra)
    {
        $this->tiposMuestra = $tiposMuestra;
    }

    public function collection()
    {
        return $this->tiposMuestra;
    }

    public function headings(): array
    {
        return [
            'Departamento',
            'Tipo de Muestra',
            'Cantidad'
        ];
    }
}

