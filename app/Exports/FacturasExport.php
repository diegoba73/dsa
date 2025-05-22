<?php

namespace App\Exports;

use App\Facturacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Facturacion::select("id", "depositante", "fecha_emision", "fecha_pago", "detalle", "importe")->get();
    }

    public function headings(): array
    {
        return [
            'Registro Id',
            'Depositante',
            'Fecha Emisión',
            'Fecha de Pago',
            'Detalle',
            'Importe',
        ];
    }

}


