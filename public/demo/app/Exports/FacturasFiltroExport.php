<?php

namespace App\Exports;

use App\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacturasFiltroExport implements FromCollection, WithHeadings
{
    protected $numero;
    protected $remitente;
    protected $departamento;
    protected $fechaEmisionInicio;
    protected $fechaEmisionFinal;
    protected $fechaPagoInicio;
    protected $fechaPagoFinal;

    public function __construct($numero, $remitente, $departamento, $fechaEmisionInicio, $fechaEmisionFinal, $fechaPagoInicio, $fechaPagoFinal)
    {
        $this->numero = $numero;
        $this->remitente = $remitente;
        $this->departamento = $departamento;
        $this->fechaEmisionInicio = $fechaEmisionInicio;
        $this->fechaEmisionFinal = $fechaEmisionFinal;
        $this->fechaPagoInicio = $fechaPagoInicio;
        $this->fechaPagoFinal = $fechaPagoFinal;
    }

    public function collection()
    {
        $facturas = Factura::numero($this->numero)
            ->remitente($this->remitente)
            ->departamento($this->departamento)
            ->fechaEmisionRango($this->fechaEmisionInicio, $this->fechaEmisionFinal)
            ->fechaPagoRango($this->fechaPagoInicio, $this->fechaPagoFinal)
            ->select("id", "remitentes_id", "departamentos_id", "fecha_emision", "fecha_pago", "estado", "total")
            ->with(['remitente', 'departamento']) // Cargar relaciones
            ->get();
    
        $totalSum = $facturas->sum('total');
    
        // Calculate the sum for "total" column only for invoices with "PAGADO" status
        $totalSumPagado = $facturas->where('estado', 'PAGADA')->sum('total');
    
        // Add a new row for total at the end
        $totalRow = [
            'id' => 'Total',
            'remitentes_id' => '',
            'departamentos_id' => '',
            'fecha_emision' => '',
            'fecha_pago' => '',
            'estado' => '',
            'total' => $totalSum,
        ];
    
        $totalPagadoRow = [
            'id' => 'Total Pagado',
            'remitentes_id' => '',
            'departamentos_id' => '',
            'fecha_emision' => '',
            'fecha_pago' => '',
            'estado' => '',
            'total' => $totalSumPagado,
        ];
    
        $facturasExport = $facturas->map(function ($factura) {
            return [
                'id' => $factura->id,
                'remitentes_id' => $factura->remitente->nombre,
                'departamentos_id' => $factura->departamento->departamento,
                'fecha_emision' => $factura->fecha_emision ? date('d-m-Y', strtotime($factura->fecha_emision)) : '',
                'fecha_pago' => $factura->fecha_pago ? date('d-m-Y', strtotime($factura->fecha_pago)) : '',
                'estado' => $factura->estado,
                'total' => $factura->total,
            ];
        });
    
        $facturasExport->push($totalRow);
        $facturasExport->push($totalPagadoRow);
    
        return $facturasExport;
    }
    
    

    public function headings(): array
    {
        return [
            'Número Factura',
            'Depositante',
            'Departamento',
            'Fecha Emisión',
            'Fecha de Pago',
            'Estado',
            'Importe',
        ];
    }

}


