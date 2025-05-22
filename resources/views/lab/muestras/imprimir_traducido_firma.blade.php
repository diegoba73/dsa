<!DOCTYPE>
<html>
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    </head>
    <title>Informe de Muestra</title>
    <style>
       @media print { 
        header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 10px; left: 0px; right: 0px; height: 50px; }
        body {
        -webkit-print-color-adjust: exact;
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 12px;
        /*font-family: SourceSansPro;*/
        }
        .boton, .boton *{
            display: none !important;
        }
        p.date {
        text-align: right;
        }
        #logo{
        margin-left: 2%;
        float: left;
        }
        img.logo{
        width: 50px; height: 50px;
        }

        #numero{
        margin-top: 70px;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 12px;
        width:auto;
        height:auto;
        }

        .encabezado{
        float: center;
        text-align: center;
        margin-left: 10%;
        margin-right: 10%;
        font-size: 12px;
        line-height: 0.2;
        }
 
        section{
        clear: left;
        }

 
        #fac, #fv, #fa{
        text-align: left;
        color: #FFFFFF;
        font-size: 13px;
        }
 
        .separador{
        margin-top:0px;
        margin-bottom:0px;
        width: 100%;
        background: #2183E3;
        text-align: center;
        color: #FFFFFF; 
        }

        #tabla_titulo {
        width: 100%;
        }

        #tabla_titulo th{
        background-color: #2183E3;
        margin-bottom: 0px;
        }

        #tabla{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 5px;
        margin-bottom: 1px;
        }
 
        #tabla thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }
        #tabla tbody{
        font-size: 10px;
        }

        #tablaEnsayo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0; 
        margin-top: 1px; 
        margin-bottom: 1px;
        page-break-inside: always;
        font-size: 12px;
        }
 
        #tablaEnsayo thead{
        padding: 20px;
        background: #596876;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }

        #tablaEnsayo tbody{
        font-size: 12px;
        }

        #tablaEnsayo tr:nth-child(even) {
        background-color: #f2f2f2
        }

        /* Analitos*/

        #tablaAnalitos{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
        margin-bottom: 1px;
        page-break-inside: always;
        font-size: 12px;
        }
 
        #tablaAnalitos thead{
        margin-top: 1px;
        background: #596876;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }

        #tablaAnalitos tbody{
        font-size: 12px;
        }

        #tablaAnalitos tr:nth-child(even) {
        background-color: #f2f2f2
        }
 
        .pie{
        text-align: center;
        font-size: 8px; 
        background-color: #f8f8f8;
        color: #000000;
        position: absolute;
        
        width: 100%;
        height: 50px;
        border-top: 1px solid #e7e7e7;
        page-break-inside: avoid;
        }

        .bottom-footer{
            border-top: 1px solid #000000;
            padding-top: 7px;
            color: #000000;
        }

        .footer-nav li{
            display: inline;
            padding: 0px 40px;
            text-align: center;
            margin-left: 10%;
            margin-right: 10%;
            font-size: 10px;
        }

        .footer-nav a{
            color: grey;
            text-decoration: none;
        }
       }
       header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 10px; left: 0px; right: 0px; height: 50px; }
        body {
        -webkit-print-color-adjust: exact;
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 12px;
        /*font-family: SourceSansPro;*/
        }
        p.date {
        text-align: right;
        }
        #logo{
        margin-left: 2%;
        float: left;
        }
        img.logo{
        width: 50px; height: 50px;
        }

        #numero{
        margin-top: 70px;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 12px;
        width:auto;
        height:auto;
        }

        .encabezado{
        float: center;
        text-align: center;
        margin-left: 10%;
        margin-right: 10%;
        font-size: 12px;
        line-height: 0.2;
        }
 
        section{
        clear: left;
        }

 
        #fac, #fv, #fa{
        text-align: left;
        color: #FFFFFF;
        font-size: 13px;
        }
 
        .separador{
        margin-top:0px;
        margin-bottom:0px;
        width: 100%;
        background: #2183E3;
        text-align: center;
        color: #FFFFFF; 
        }

        #tabla_titulo {
        width: 100%;
        }

        #tabla_titulo th{
        background-color: #2183E3;
        margin-bottom: 0px;
        }

        #tabla{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 5px;
        margin-bottom: 1px;
        }
 
        #tabla thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }
        #tabla tbody{
        font-size: 13px;
        }

        #tablaEnsayo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0; 
        margin-top: 1px; 
        margin-bottom: 1px;
        page-break-inside: always;
        font-size: 12px;
        }
 
        #tablaEnsayo thead{
        padding: 20px;
        background: #596876;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }

        #tablaEnsayo tbody{
        font-size: 12px;
        }

        #tablaEnsayo tr:nth-child(even) {
        background-color: #f2f2f2
        }

        /* Analitos*/

        #tablaAnalitos{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
        margin-bottom: 1px;
        page-break-inside: always;
        font-size: 10px;
        }
 
        #tablaAnalitos thead{
        margin-top: 1px;
        background: #596876;
        text-align: left;
        border-bottom: 1px solid #FFFFFF; 
        }

        #tablaAnalitos tbody{
        font-size: 10px;
        }

        #tablaAnalitos tr:nth-child(even) {
        background-color: #f2f2f2
        }
 
        .pie{
        text-align: center;
        font-size: 8px; 
        background-color: #f8f8f8;
        color: #000000;
        position: absolute;
        
        width: 100%;
        height: 50px;
        border-top: 1px solid #e7e7e7;
        page-break-inside: avoid;
        }

        .bottom-footer{
            border-top: 1px solid #000000;
            padding-top: 7px;
            color: #000000;
        }

        .footer-nav li{
            display: inline;
            padding: 0px 40px;
            text-align: center;
            margin-left: 10%;
            margin-right: 10%;
            font-size: 10px;
        }

        .footer-nav a{
            color: grey;
            text-decoration: none;
        }
    </style>
    <body>
        <header>
            <div id="logo">
                <img class="logo" src="{{ asset('argon/img/brand/escudo.png') }}" alt="Lab">
            </div>
            <div class="encabezado">
               
                    <h2>ANNEX ESSAY REPORT (Original in Spanish – Nº {{$muestra->numero}} / {{$FechaEntrada = date("y", strtotime($muestra->fecha_entrada))}}) </h2>
                    <h3>Laboratory Department</h3>

            </div> 
        </header>
        <div id="numero">
                    
                    <div style="float:left;"><p><strong>Laboratory nº: R0107 – Senasa  Net </strong></p><p><strong>SAMPLE NBR.: {{$muestra->numero}} / {{$FechaEntrada = date("y", strtotime($muestra->fecha_entrada))}}</strong></p></div>
                    <div style="float:right;"><p>Printing Date: {{ date('jS F Y') }}</p></div>     
                            
        </div>
        <section>
        
            <div>  
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th style="width:765px" align="center"><font color="#fff"><strong>Applicant’s information</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                    <tbody>
                        <tr>
                            <td style="width:420px"><strong>Applicant: </strong>{{$muestra->solicitante}}</td>
                            <td style="width:400px"><strong>Applicant’saddress: </strong>{{$muestra->remitente->direccion}}</td>
                            <td></td>
                            
                        </tr>
                        <tr>
                            <td style="width:420px"><strong>Sender: </strong>{{$muestra->remitente->nombre}}</td>
                        </tr>
                        </tbody>
                </table>
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th style="width:765px" align="center"><font color="#fff"><strong>Sample information</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                        <tbody>
                        <tr>
                            <td><strong>Matrix: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->matriz->matriz, 'en') }}</td>
                            <td><strong>Identification: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->identificacion, 'en') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Sample: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->tipomuestra->tipo_muestra, 'en') }}</td>
                            <td><strong>Type: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->muestra, 'en') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date of entrance: </strong>{{$FechaEntrada = date("jS F Y", strtotime($muestra->fecha_entrada))}}</td>
                            <td><strong>Date of collection: </strong>{{$FechaExtraccion = date("jS F Y", strtotime($muestra->fecha_extraccion))}} <strong>Hora Extracción: </strong>{{$muestra->hora_extraccion}}</td>
                            
                        </tr>
                        <tr>
                            <td><strong>Sampling performed by: </strong>{{$muestra->realizo_muestreo}}</td>
                            <td><strong>Place of collection: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->lugar_extraccion, 'en') }}</td>
                        </tr>
                        <tr>
                            <td><strong>City: </strong>{{$muestra->localidad->localidad}}</td>
                            <td><strong>Province: </strong>{{$muestra->provincia->provincia}}</td>
                        <tr>
                            <td><strong>Units: </strong>{{$muestra->cantidad}} <strong>Weight / Volume: </strong>{{$muestra->peso_volumen}}</td>
                        </tr>
                        <tr>
                            <td><strong>Produced by: </strong>{{$muestra->elaborado_por}}</td>
                            <td><strong>Producer’s address: </strong>{{$muestra->domicilio}}</td>
                            
                        </tr>
                        <tr>
                            
                            <td><strong>Production date: </strong>{{ app('App\Http\Controllers\TraductorController')->traducir($muestra->fecha_elaborado, 'en') }}</td>
                            <td><strong>Expiry date: </strong>{{$muestra->fecha_vencimiento}}</td>
                        </tr>
                        <tr>
                            <td><strong>Mark: </strong>{{$muestra->marca}}</td>
                            <td colspan="2"><strong>Establishment register nbr: </strong>{{$muestra->registro_establecimiento}} | <strong>Product register: </strong>{{$muestra->registro_producto}}</td>
                            
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Lot nbr: </strong>{{$muestra->lote}}</td>
                        </tr>
                        <tr>
                            <td><strong>Quantity: </strong>{{$muestra->partida}}</td>
                            <td><strong>Destination: </strong>{{$muestra->destino}}</td>
                        </tr>
                        </tbody>
                </table>
                <p><b>Information relative to the sample is provided by the applicant.</b></p>
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th class="titulo" style="width:765px" align="center"><font color="#fff"><strong>Analysis Data</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                </tr>
                    <tbody>
                        <tr>
                            <td style="width:500px"><strong>Beginning date: </strong>@if (strtotime($muestra->fecha_inicio_analisis) > 0){{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_inicio_analisis))}}@else @endif</td>
                            
                            <td style="width:500px"><strong>Ending date: </strong>@if (strtotime($muestra->fecha_fin_analisis) > 0){{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_fin_analisis))}}@else @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <div>
            <hr/>
                <table id="tablaEnsayo">
                    <thead>
                        <tr id="fv">
                            <th>ESSAY</th>
                            <th>METHOD</th>
                            <th align="center">RESULT</th>
                            <th align="left">UNITS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($muestra->ensayos as $ensayo)
                        <tr>
                            <td style="width:400px;">{{ app('App\Http\Controllers\TraductorController')->traducir($ensayo->ensayo, 'en') }}</td>
                            <td style="width:150px;">{{$ensayo->norma_procedimiento}}</td>
                            <td align="center">{{ app('App\Http\Controllers\TraductorController')->traducir($ensayo->pivot->resultado, 'en') }}</td>
                            <td style="width:120px;align="left">{{$ensayo->unidades}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <div><strong>Observaciones: </strong>{{$muestra->observaciones}}</div>
        <table>
                <tr>
                <td style="padding-left: 100px; padding-top: 0; padding-bottom: 0;"></td><td style="text-align: center; vertical-align: middle;"><img src="{{ asset('argon/img/brand/firma_lab.png') }}" alt="Firma" id="imagen" width="500"></td>
                </tr>
        </table>
        <footer class="pie">
        <div><strong><span style="float:left">ND: Not Detectable</span></strong></div>
            <div class="bottom-footer">
                <span><b>The results reported refer exclusively to the sample received and the Laboratory declines all responsibility for any improper use of this report. This certificate may only be reproduced in its entirety and only with the written authorization of the Laboratory.</b></span>
                <span>Berwyn 226, Trelew - Chubut, Argentina - Tel.:(+54) 280 4427421/4421011 - Email:laboratoriodpsachubut@gmail.com</span>
            </div>
        </footer>
    </body>
    <div align="center">
    <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

        <script src="{{ asset('/js/submit.js') }}" ></script>

        <script src="{{ asset('/js/plugins/chosen/chosen.jquery.js') }}" ></script>
        <script src="{{ asset('/js/plugins/chosen/docsupport/init.js') }}" ></script>
        <script src="{{ asset('/js/plugins/chosen/docsupport/prism.js') }}" ></script>
</html>