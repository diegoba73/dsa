<?php

namespace App\Exports;

use App\Muestra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CondicionDbExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $condicionesdb;

    public function __construct($condicionesdb)
    {
        $this->condicionesdb = $condicionesdb;
    }

    public function collection()
    {
        return $this->condicionesdb;
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

