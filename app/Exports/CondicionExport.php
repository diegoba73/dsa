<?php

namespace App\Exports;

use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CondicionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $condiciones;

    public function __construct($condiciones)
    {
        $this->condiciones = $condiciones;
    }

    public function collection()
    {
        return $this->condiciones;
    }

    public function headings(): array
    {
        return [
            'Departamento',
            'Tipo de Muestra',
            'Condición',
            'Ensayo',
            'Total'
        ];
    }
}

