<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de Muestra</title>
    <style>
        @page {
                size: A4;
            }
       @media print { 
        header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 5px; left: 0px; right: 0px; height: 50px; }
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
        page-break-inside: always;
        size: A4;
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
 
        section, div {
        clear: left;
        page-break-inside: avoid;
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
        page-break-inside: avoid;
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
 
        .pie{
        text-align: center;
        font-size: 8px; 
        background-color: #f8f8f8;
        color: #000000;
        position: absolute;
        
        width: 100%;
        height: 20px;
        border-top: 1px solid #e7e7e7;
        page-break-inside: avoid;
        }

        .bottom-footer{
            border-top: 1px solid #000000;
            padding-top: 5px;
            color: #000000;
            page-break-inside: avoid;
        }
       }
       header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 5px; left: 0px; right: 0px; height: 50px; }
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
            page-break-inside: avoid;
        }
    </style>
    <body>
        <header>
            <div id="logo">
                <img class="logo" src="{{ asset('argon/img/brand/escudo.png') }}" alt="Lab">
            </div>
            <div class="encabezado">
                    <h1>Informe de Rechazo</h1>
                    <h2>Departamento Provincial Laboratorio</h2>
                    <h3>Dirección Provincial una Salud</h3>
                    <h4>Secretaría de Salud</h4>
            </div> 
        </header>
        <div id="numero">
            <hr/>
                    <div style="float:left;"><p><strong>Número de Muestra: {{$muestra->numero}} / {{$FechaEntrada = date("y", strtotime($muestra->fecha_entrada))}}</strong></p></div>
                    <div style="float:right;"><p>Fecha de Impresión: {{date('d/m/Y')}}</p></div>               
        </div>
        <section> 
            <div>  
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th style="width:765px" align="center"><font color="#fff"><strong>Datos del Solicitante</strong></th>
                <th></th>
                </tr>
                </table>
                <table id="tabla">
                    <tbody>
                        <tr>
                            <td style="width:420px"><strong>Solicitante: </strong>{{$muestra->solicitante}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:420px"><strong>Remite: </strong>{{$muestra->remitente->nombre}}</td>
                            <td style="width:400px"><strong>Dirección del Remitente: </strong>{{$muestra->remitente->direccion}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:420px"><strong>Localidad: </strong>{{$muestra->remitente->localidad->localidad}}</td>
                            <td style="width:400px"><strong>Provincia: </strong>{{$muestra->remitente->localidad->provincia->provincia}}</td>
                            <td></td>
                        </tr>
                        </tbody>
                </table>
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
                        </tr>
                        <tr>
                            <td><strong>Tipo de Entrada: </strong>{{$muestra->entrada}}</td>
                            <td><strong>Matriz: </strong>{{$muestra->matriz->matriz}}</td>
                            <td><strong>Tipo de Muestra: </strong>{{$muestra->tipo_muestra}}</td>
                        </tr>
                        <tr>
                            <td><strong>Muestra: </strong>{{$muestra->muestra}}</td>
                            <td></td>
                            <td><strong>Identificación: </strong>{{$muestra->identificacion}}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Entrada: </strong>{{$FechaEntrada = date("d/m/Y", strtotime($muestra->fecha_entrada))}}</td>
                            <td><strong>Fecha de Extracción: </strong>{{$FechaExtraccion = date("d/m/Y", strtotime($muestra->fecha_extraccion))}}</td>
                            <td><strong>Realizo Muestreo: </strong>{{$muestra->realizo_muestreo}}</td>
                        </tr>
                        <tr>
                            <td><strong>Lugar de Extracción: </strong>{{$muestra->lugar_extraccion}}</td>
                            <td><strong>Localidad: </strong>{{$muestra->localidad->localidad}}</td>
                            <td><strong>Provincia: </strong>{{$muestra->provincia->provincia}}</td>
                        <tr>
                            <td><strong>Conservación: </strong>{{$muestra->conservacion}}</td>
                            <td></td>
                            <td><strong>Cloro Residual: </strong>{{$muestra->cloro_residual}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Envase: </strong>{{$muestra->tipo_envase}}</td>
                            <td><strong>Cantidad: </strong>{{$muestra->cantidad}}</td>
                            <td><strong>Peso/Volúmen: </strong>{{$muestra->peso_volumen}}</td>
                        </tr>
                        @if ($muestra->departamento_id == 4 || $muestra->departamento_id == 5)
                        <tr></tr>
                        @else
                        <tr>
                            <td><strong>Elaborado por: </strong>{{$muestra->elaborado_por}}</td>
                            <td><strong>Domicilio: </strong>{{$muestra->domicilio}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Marca: </strong>{{$muestra->marca}}</td>
                            <td><strong>Fecha de Elaboración: </strong>{{$muestra->fecha_elaboracion}}</td>
                            <td><strong>Fecha de Vencimiento: </strong>{{$muestra->fecha_vencimiento}}</td>
                        </tr>
                        <tr>
                            <td><strong>Reg. Establecimiento: </strong>{{$muestra->registro_establecimiento}}</td>
                            <td></td>
                            <td><strong>Reg. Producto: </strong>{{$muestra->registro_producto}}</td>
                        </tr>
                        <tr>
                            <td><strong>Lote: </strong>{{$muestra->lote}}</td>
                            <td><strong>Partida: </strong>{{$muestra->partida}}</td>
                            <td><strong>Destino: </strong>{{$muestra->destino}}</td>
                        </tr>
                        @endif
                        </tbody>
                </table>
            </div>
        </section>
        <table id="tabla_titulo">
                <tr>
                <th></th>
                <th style="width:765px" align="center"><font color="#fff"><strong>Criterio de Rechazo</strong></th>
                <th></th>
                </tr>
                </table>
        <section>
            <div>
            <hr/>
                <table id="tabla">
                    <tbody>
                        <tr>
                            <td>{{$muestra->criterio_rechazo}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <div><strong>Observaciones: </strong>{{$muestra->observaciones}}</div>
        <table>
                <tr>
                <td></td><td><img src="{{ asset('argon/img/brand/firma_lab.jpg') }}" alt="Firma" id="imagen" width="600" height="300"></td>
                </tr>
        </table>
        <footer class="pie">
            <div class="bottom-footer">
                <p><b>Los resultados consignados se refieren exclusivamente a la muestra recibida y el Laboratorio declina toda responsabilidad por el uso indebido que se hiciere de éste informe. El presente certificado solo puede ser reproducido integramente y con autorización escrita del Laboratorio</b></p>
                <p>Berwyn 226, Trelew - Chubut, Argentina - Telefono:(+54) 280 4427421/4421011 - Email:laboratoriodpsachubut@gmail.com</p>
            </div>
        </footer>
    </body>
    <div align="center">
        <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</html>