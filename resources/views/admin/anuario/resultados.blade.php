@extends('layouts.app')

@section('content')
<style>
    canvas {
        max-height: 400px;
        max-width: 400px;
        margin: 0 auto;
        display: block;
    }
  </style>
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="content">
            

                </div>
            </div>
        </div>
    
    <div class="container-fluid mt--8">
        <div class="row mt-9">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0" style="color:white">Datos Anuario {{ $year }}</h3>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;">
                        <div style="flex: 50%; background-color: #f1f1f1;">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                            <h2>Muestras</h2>
                                        </div>
                                        <div class="card-body">
                                            <p>Cantidad total de muestras: {{ $muestras->count() }}</p>
                                            <br>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Cantidad de muestras</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($muestras_por_departamento as $departamento)
                                                    <tr>
                                                    <td>{{ $departamento->departamento }}</td>
                                                        <td>{{ $departamento->cantidad }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <canvas id="muestras_dpto"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                            <h2>Cantidad por tipo de prestación</h2>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo prestacion</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tiposPrestaciones as $tiposPrestacion)
                                                    <tr>
                                                    <td>{{ $tiposPrestacion->tipo_prestacion }}</td>
                                                    <td>{{ $tiposPrestacion->total }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                            <canvas id="prestaciones"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                            <h2>Cantidad por tipo de prestación por Dpto</h2>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Tipo prestacion</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tiposPrestacionesDpto as $tiposPrestacion)
                                                    <tr>
                                                    <td>{{ $tiposPrestacion->departamento }}</td>
                                                    <td>{{ $tiposPrestacion->tipo_prestacion }}</td>
                                                    <td>{{ $tiposPrestacion->total }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                            <h2>Cantidad de Muestras por Area</h2>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Cantidad de muestras de Microbiología: {{ $muestrasMicrobiologia }}</li>
                                                <li>Cantidad de muestras de Química Alimentos: {{ $muestrasQuimicaAlimentos }}</li>
                                                <li>Cantidad de muestras de Química Agua: {{ $muestrasQuimicaAgua }}</li>
                                                <li>Cantidad de muestras de ensayo biológico: {{ $muestrasEnsayoBiologico }}</li>
                                                <li>Cantidad de muestras de cromatografía: {{ $muestrasCromatografia }}</li>
                                            </ul>
                                        </div>
                                        <canvas id="areas"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Cantidad de tipos de ensayos</h2>
                                        </div>
                                        <div>
                                        <a href="{{ route('exportar.tipoensayo', ['year' => $year]) }}" class="btn btn-success">Exportar tipos de ensayos para {{ $year }}</a>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Dpto</th>
                                                        <th>Tipo de muestra</th>
                                                        <th>Tipo de ensayo</th>
                                                        <th>Cantidad de ensayos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($matrizs as $matriz)
                                                        <tr>
                                                            <td>{{ $matriz->departamento }}</td>
                                                            <td>{{ $matriz->matriz }}</td>
                                                            <td>{{ $matriz->tipo_ensayo }}</td>
                                                            <td>{{ $matriz->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 50%; background-color: #ddd;">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Cantidad de muestras por matriz</h2>
                                        </div>
                                        <div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Matriz</th>
                                                        <th>Cantidad</th>
                                                        <th>Porcentaje</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($matriz_t as $m)
                                                        <tr>
                                                            <td>{{ $m->matriz }}</td>
                                                            <td>{{ $m->total }}</td>
                                                            <td>{{ $m->porcentaje }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="chart-container">
                                        <canvas id="chart" width="800" height="600"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Cantidad de muestras por matriz y dpto</h2>
                                        </div>
                                        <div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Matriz</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($matriz_dpto as $m)
                                                        <tr>
                                                            <td>{{ $m->departamento }}</td>
                                                            <td>{{ $m->matriz }}</td>
                                                            <td>{{ $m->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Cantidad de muestras por tipo de muestra</h2>
                                        </div>
                                        <div>
                                        <a href="{{ route('exportar.tipomuestra', ['year' => $year]) }}" class="btn btn-success">Exportar tipos de muestra para {{ $year }}</a>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Tipo de muestra</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tiposMuestra as $tipomuestra)
                                                        <tr>
                                                            <td>{{ $tipomuestra->departamento }}</td>
                                                            <td>{{ $tipomuestra->tipo_muestra }}</td>
                                                            <td>{{ $tipomuestra->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Cantidad de ensayos totales por área</h2>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo de ensayo</th>
                                                        <th>Cantidad de ensayos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ensayos as $ensayo)
                                                        <tr>
                                                            <td>{{ $ensayo->tipo_ensayo }}</td>
                                                            <td>{{ $ensayo->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="alert alert-info" role="alert">
                                <h1>Bromatologia</h2>
                                </div>
                                <div style="display: flex;">
                                    <div style="display: inline-block;" class="card-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h1 style="color: white;">Origen de las muestras</h1>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Origen</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Provincial</td>
                                                    <td>{{ $muestras_prov->muestras_prov }}</td>
                                                </tr>
                                                <tr>
                                                    <td>ExtraProvincial</td>
                                                    <td>{{ $muestras_prov->muestras_extraprov }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="display: inline-block;" class="card-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h1 style="color: white;">Toxina paralizante</h1>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Mayor a 400 UR</th>
                                                    <th>Menor a 400 UR o ND</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $mrmayor }}</td>
                                                    <td>{{ $mrmenor }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="display: inline-block;" class="card-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h1 style="color: white;">Toxina diarreica</h1>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Negativas</th>
                                                    <th>Postivas</th>
                                                    <th>No realizada - Interferencia</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $diarreica_neg }}</td>
                                                    <td>{{ $diarreica_pos }}</td>
                                                    <td>{{ $diarreica_int }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="display: inline-block;" class="card-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h1 style="color: white;">Toxina amnesica</h1>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Negativas</th>
                                                    <th>Postivas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $amnesica_neg }}</td>
                                                    <td>{{ $amnesica_pos }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="display: inline-block;" class="card-body">
                                        <div class="alert alert-primary" role="alert">
                                            <h1 style="color: white;">Trichinella spiralis</h1>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Negativas</th>
                                                    <th>Postivas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $triq_neg }}</td>
                                                    <td>{{ $triq_pos }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="alert alert-info" role="alert">
                                <h1>D.S.B.</h2>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="alert alert-primary" role="alert">
                                            <h2>Condición de aptitud por departamento</h2>
                                            <div>
                                            <a href="{{ route('exportar.condiciones', ['year' => $year]) }}" class="btn btn-success">Exportar condiciones para {{ $year }}</a>
                                            </div>
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Departamento</th>
                                                            <th>Tipo muetsra</th>
                                                            <th>Condicion</th>
                                                            <th>Ensayo</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($condicionesdsb as $condicion)
                                                        <tr>
                                                        <td>{{ $condicion->departamento }}</td>
                                                        <td>{{ $condicion->tipomuestra }}</td>
                                                        <td>{{ $condicion->condicion }}</td>
                                                        <td>{{ $condicion->tipo }}</td>
                                                        <td>{{ $condicion->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="alert alert-info" role="alert">
                                <h1>D.S.O.</h2>
                                </div>
                                <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Condición de aptitud por departamento</h2>
                                        <div>
                                        <a href="{{ route('exportar.condiciones', ['year' => $year]) }}" class="btn btn-success">Exportar condiciones para {{ $year }}</a>
                                        </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Tipo muetsra</th>
                                                        <th>Condicion</th>
                                                        <th>Ensayo</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($condicionesdso as $condicion)
                                                    <tr>
                                                    <td>{{ $condicion->departamento }}</td>
                                                    <td>{{ $condicion->tipomuestra }}</td>
                                                    <td>{{ $condicion->condicion }}</td>
                                                    <td>{{ $condicion->tipo }}</td>
                                                    <td>{{ $condicion->total }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="alert alert-info" role="alert">
                                <h1>Bromatología</h2>
                                </div>
                                <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="alert alert-primary" role="alert">
                                        <h2>Condición de aptitud por departamento</h2>
                                        <div>
                                        <a href="{{ route('exportar.condicionesdb', ['year' => $year]) }}" class="btn btn-success">Exportar condiciones para {{ $year }}</a>
                                        </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Tipo muetsra</th>
                                                        <th>Condicion</th>
                                                        <th>Ensayo</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($condicionesdb as $condicion)
                                                    <tr>
                                                    <td>{{ $condicion->departamento }}</td>
                                                    <td>{{ $condicion->tipomuestra }}</td>
                                                    <td>{{ $condicion->condicion }}</td>
                                                    <td>{{ $condicion->tipo }}</td>
                                                    <td>{{ $condicion->total }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
</div>

@endsection
<script>
    Chart.controllers.horizontalBar = Chart.controllers.bar.extend({});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Pie chart for muestras por departamento
    var muestras_por_departamento = {!! json_encode($muestras_por_departamento) !!};

    var departamentos = muestras_por_departamento.map(function(d) { return 'Departamento ' + d.departamento; });
    var cantidades = muestras_por_departamento.map(function(d) { return d.cantidad; });

    var colores_departamentos = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)'
    ];

    // Pie chart for tipo de prestaciones
    var tipo_prestaciones = {!! json_encode($tiposPrestaciones) !!};

    var prestaciones = tipo_prestaciones.map(function(d) { return 'Prestación ' + d.tipo_prestacion; });
    var total = tipo_prestaciones.map(function(d) { return d.total; });

    var colores_prestacion = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)'
    ];
    

    // Pie chart for muestras por área
    var etiquetas = ['Microbiología', 'Química de Alimentos', 'Química de Agua', 'Ensayo Biológico', 'Cromatografía'];
    var valores = [
        {{ $muestrasMicrobiologia }},
        {{ $muestrasQuimicaAlimentos }},
        {{ $muestrasQuimicaAgua }},
        {{ $muestrasEnsayoBiologico }},
        {{ $muestrasCromatografia }}
    ];

    var colores_areas = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)'
    ];

    var matriz_t = {!! json_encode($matriz_t) !!};
    
    // Obtener los nombres de las matrices y los porcentajes
    var matriz_names = matriz_t.map(function(d) { return d.matriz; });
    var matriz_perc = matriz_t.map(function(d) { return d.porcentaje; });
    
    // Generar los colores para cada matriz
    var matriz_colors = matriz_t.map(function(d, i) { 
        var hue = (i * 137.508) % 360;
        return 'hsla(' + hue + ', 70%, 50%, 0.7)';
    });

    // Create charts
    window.onload = function() {

        //Grafico de matrices
        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: matriz_names,
                datasets: [{
                    backgroundColor: matriz_colors,
                    data: matriz_perc
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index] || '';
                            var value = data.datasets[0].data[tooltipItem.index];
                            var percent = Number.parseFloat(value).toFixed(2) + '%';
                            return label + ': ' + percent;
                        }
                    }
                }
            }
        });



        var ctx1 = document.getElementById('muestras_dpto').getContext('2d');
        var chart1 = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: departamentos,
                datasets: [{
                    label: 'Cantidad de muestras',
                    data: cantidades,
                    backgroundColor: colores_departamentos,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {}
        });
        var ctx2 = document.getElementById('prestaciones').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: prestaciones,
                datasets: [{
                    label: 'Tipo prestaciones',
                    data: total,
                    backgroundColor: colores_prestacion,
                    borderWidth: 1,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(0, 255, 0, 0.2)',
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(128, 128, 128, 0.2)'
                    ]
                }]
            },
            options: {}
        });

        var ctx3 = document.getElementById('areas').getContext('2d');
        var chart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: etiquetas,
                datasets: [{
                    data: valores,
                    backgroundColor: colores_areas,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 0, 0, 0.2)',
                        'rgba(0, 255, 0, 0.2)',
                        'rgba(0, 0, 255, 0.2)',
                        'rgba(128, 128, 128, 0.2)'
                    ]
                }]
            },
            options: {}
        });
        }
</script>


