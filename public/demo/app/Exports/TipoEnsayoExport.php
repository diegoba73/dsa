<?php

namespace App\Exports;

use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TipoEnsayoExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $tipoEnsayo;

    public function __construct($tipoEnsayo)
    {
        $this->tipoEnsayo = $tipoEnsayo;
    }

    public function collection()
    {
        return $this->tipoEnsayo;
    }

    public function headings(): array
    {
        return [
            'Departamento',
            'Tipo de Muestra',
            'Tipo de Ensayos',
            'Cantidad'
        ];
    }
}

