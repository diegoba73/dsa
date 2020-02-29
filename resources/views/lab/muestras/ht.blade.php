<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de trabajo</title>
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
        margin-top: 90px;
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
        font-size: 10px;
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
        height: 40px;
        border-top: 1px solid #e7e7e7;
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
        margin-top: 90px;
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
        font-size: 10px;
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
        height: 40px;
        border-top: 1px solid #e7e7e7;
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
                <img class="logo" src="{{ asset('argon/img/brand/logo.png') }}" alt="Lab">
            </div>
            <div class="encabezado">
               
                    <h1>Hoja de Trabajo</h1>
                    <h2>Departamento Provincial Laboratorio</h2>
                    <h3>Dirección Provincial de Salud Ambiental</h3>
                    <h4>Ministerio de Salud</h4>

            </div> 
        </header>
        <div id="numero">
            <hr/>
                    <div style="float:left;"><p><strong>Número de Muestra: {{$muestra->numero}} / {{$FechaEntrada = date("y", strtotime($muestra->fecha_entrada))}}</strong></p><p><strong>Departamento: </strong>{{$muestra->departamento->departamento}} <strong>Usuario: </strong>{{$muestra->user->usuario}} </p></div>
                    <div style="float:right;"><p>Fecha de Impresión: {{date('d/m/Y')}}</p></div>     
                            
        </div>
        <section>
        
            <div>  
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th style="width:765px" align="center"><font color="#fff"><strong>Datos de la muestra</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                        <tbody>
                        <tr>
                            
                            <td><strong>Nº certificado cadena de custodia: </strong>{{$muestra->nro_cert_cadena_custodia}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Entrada: </strong>{{$muestra->entrada}}</td>
                            <td><strong>Matriz: </strong>{{$muestra->matriz->matriz}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Muestra: </strong>{{$muestra->tipomuestra->tipo_muestra}}</td>
                            <td><strong>Identificación: </strong>{{$muestra->identificacion}}</td>
                        </tr>
                        <tr>
                            <td><strong>Muestra: </strong>{{$muestra->muestra}}</td>
                            <td><strong>Fecha de Entrada: </strong>{{$FechaEntrada = date("d/m/Y", strtotime($muestra->fecha_entrada))}}</td>
                        </tr>
                        <tr>
                            <td><strong>Lugar de extracción: </strong>{{$muestra->lugar_extraccion}}</td>
                            <td><strong>Fecha de Extracción: </strong>@if (strtotime($muestra->fecha_extraccion) > 0){{$FechaExtraccion = date("d/m/Y", strtotime($muestra->fecha_extraccion))}} <strong>Hora Extracción: </strong>{{$muestra->hora_extraccion}}@else @endif</td>
                        </tr>
                        <tr>
                            <td><strong>Localidad: </strong>{{$muestra->localidad->localidad}}</td>
                            <td><strong>Provincia: </strong>{{$muestra->provincia->provincia}}</td>
                        <tr>
                            <td><strong>Conservación: </strong>{{$muestra->conservacion}}</td>
                            <td><strong>Cloro Residual: </strong>{{$muestra->cloro_residual}}</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad: </strong>{{$muestra->cantidad}}</td>
                            <td><strong>Peso/Volúmen: </strong>{{$muestra->peso_volumen}}</td>
                        </tr>
                        @if ($muestra->departamento_id == 3 || $muestra->departamento_id == 4)
                        <tr></tr>
                        @else
                        <tr>
                            <td><strong>Fecha de Elaboración: </strong>{{$muestra->fecha_elaborado}}</td>
                            <td><strong>Fecha de Vencimiento: </strong>{{$muestra->fecha_vencimiento}}</td>
                        </tr>
                        <tr>
                            <td><strong>Lote: </strong>{{$muestra->lote}}</td>
                            <td><strong>Partida: </strong>{{$muestra->partida}}</td>
                        </tr>
                        @endif
                        </tbody>
                </table>
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th class="titulo" style="width:765px" align="center"><font color="#fff"><strong>Datos del Análisis</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                </tr>
                    <tbody>
                        <tr>
                            <td style="width:500px"><strong>Fecha de inicio de análisis: </strong>@if (strtotime($muestra->fecha_inicio_analisis) > 0){{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_inicio_analisis))}}@else @endif</td>
                            
                            <td style="width:500px"><strong>Fecha de fin de análisis: </strong>@if (strtotime($muestra->fecha_fin_analisis) > 0){{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_fin_analisis))}}@else @endif</td>
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
                            <th>Ensayo Solicitado</th>
                            <th>Norma/Proced.</th>
                            <th align="center">Resultado</th>
                            <th align="left">Unidades</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($muestra->ensayos as $ensayo)
                        <tr>
                            <td style="width:400px;">{{$ensayo->ensayo}}</td>
                            <td style="width:150px;">{{$ensayo->norma_procedimiento}}</td>
                            <td align="center"></td>
                            <td style="width:100px;" align="left">{{$ensayo->unidades}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <footer class="pie">
        </footer>
    </body>
    <br>
    <br>
    <br>
    <br>
    <div align="center">
    <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</html>