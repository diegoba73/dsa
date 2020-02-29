<!DOCTYPE>
@extends('layouts.imprimir', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.insumos.imprimir_stock', 'title' => __('Sistema DPSA')])
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Listado de Insumos</title>

<style>
       @media print {
        pre, blockquote {page-break-inside: avoid;}
        .boton, .boton *{
            display: none !important;
        }
        table.stock tr:nth-child(even) {
        background-color: black;
        }
       }

       div.boton { 
           text-align: center;
       }

       table.insumo{
        width: 100%;
        margin-top: -35px;
        margin-bottom: 1px;
        border: 1px solid black;
        }

        table.insumo th{
            border-bottom: 1px solid black;
        }

        table.insumo td{
        background-color: #f2f2f2;
        }

        
        table.stock{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
        margin-bottom: 1px;
        font-size: 10px;
        border-bottom: 1px solid black;
        }
 
        table.stock thead{
        padding: 20px;
        background: #a5b9cc;
        text-align: left;
        border: 1px solid black;
        
        }

        table.stock tbody, table.stock td{
        font-size: 12px;
        border-bottom: 1px solid black;
        }

        table.stock tr:nth-child(even) {
        background-color: #f2f2f2
        }

</style>


    <h1>Listado de Stock</h1>
    <div class="boton">
    @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                    <!-- Buscador -->
                    <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                    <div class="card-body">
                        <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                            <div class="container-fluid">
                            <h2 style = "color: white">Buscador</h2>
                            {{ Form::open(['route' => 'lab_insumos_imprimir', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group mr-5">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('codigo', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Código']) }}
                                    </div>
                                </div>
                                <div class="form-group mr-5">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('nombre', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nombre']) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Cromatografía:</label>
                                    {!! Form::checkbox('cromatografia', true, NULL) !!} &emsp;&emsp;
                                    <label class="bmd-label-floating">Química:</label> 
                                    {!! Form::checkbox('quimica', true, NULL) !!} &emsp;&emsp;
                                    <label class="bmd-label-floating">Ensayo Biológico:</label>
                                    {!! Form::checkbox('ensayo_biologico', true, NULL) !!} &emsp;&emsp;
                                    <label class="bmd-label-floating">Microbiología:</label>
                                    {!! Form::checkbox('microbiologia', true, NULL) !!} &emsp;&emsp;
                                </div>
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group mr-1">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_insumos_imprimir') }}">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </nav>
                    </div>
                </div>
    @endif
    <br>
    <a class="btn btn-success text-white" onclick="window.print();">Imprimir</a>
    </div>
    <div class="tabla">
        <br>            
            @foreach ($insumos as $insumo)
            <blockquote>
            <br>   
                <table class="insumo">
                <thead>
                    <tr>
                        <th style="width:100px; text-align: center">Código</th>
                        <th style="width:300px; text-align: center">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td align="center">{{ $insumo->codigo}}</td>
                    <td align="center">{{ $insumo->nombre}}</td>&emsp;
                </tr>
                <table class="stock">
                <thead>
                    <tr>
                        <th style="width:100px; text-align: center">Registro</th>
                        <th style="width:100px; text-align: left">Fecha Entrada</th>
                        <th style="width:100px; text-align: left">Fecha Baja</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Almacenaiento</th>
                        <th scope="col">En Uso</th>
                        <th scope="col">Area</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($insumo->stockinsumos as $stockinsumo)
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 8)
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td style="width:100px; text-align: left">{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td style="width:100px; text-align: left">{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @elseif ((Auth::user()->role_id == 3)&&($stockinsumo->area == 'QUIMICA ALIMENTOS'))
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @elseif ((Auth::user()->role_id == 4)&&($stockinsumo->area == 'QUIMICA AGUAS'))
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @elseif ((Auth::user()->role_id == 5)&&($stockinsumo->area == 'ENSAYO BIOLOGICO'))
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @elseif ((Auth::user()->role_id == 6)&&($stockinsumo->area == 'CROMATOGRAFIA'))
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @elseif ((Auth::user()->role_id == 7)&&($stockinsumo->area == 'MICROBIOLOGIA'))
                <tr>
                    <td align="center">{{ $stockinsumo->registro}}</td>
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_entrada))}}</td>
                    @if (strtotime($stockinsumo->fecha_baja) > 0)
                    <td>{{ date('d-m-Y', strtotime($stockinsumo->fecha_baja))}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $stockinsumo->marca}}</td>
                    <td>{{ $stockinsumo->almacenamiento}}</td>
                    <td>{{ $stockinsumo->cantidad}}</td>
                    <td>{{ $stockinsumo->area}}</td>
                </tr>
                @endif
                @endforeach
                </tbody> 
                </table>    
            </tbody>
        </table>
        </blockquote> 
        <hr/>  
        @endforeach
    </div>
</html>