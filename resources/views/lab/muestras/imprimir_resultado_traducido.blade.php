<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de Muestra</title>
    <style>
        @page { margin: 80px 25px; }
        header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 0px; left: 0px; right: 0px; height: 50px; }
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 13px;
        /*font-family: SourceSansPro;*/
        }
        p.date {
        text-align: right;
        }
        #logo{
        float: left;
        margin-bottom: 5%;
        margin-left: 2%;
        margin-right: 2%;
        width:auto;
        height:auto;
        }
        #logo2{
        float: right;
        margin-bottom: 5%;
        margin-left: 2%;
        margin-right: 2%;
        width:auto;
        height:auto;
        }

        #numero{
        margin-top: 110px;
        margin-left: 2%;
        margin-right: 2%;
        width:auto;
        height:auto;
        }

        .encabezado{
        float: center;
        margin-top: 0%;
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

        #tabla{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
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

        .top-header{
            border-bottom: 1px solid #000000;
            margin-bottom: 0px;
            padding-bottom: 7px;
            color: #000000;
        }
 
        .pie{
        text-align: center;
        font-size: 8px; 
        background-color: #f8f8f8;
        color: #000000;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 40px;
        border-top: 1px solid #e7e7e7;
        }

        .bottom-footer{
            border-top: 1px solid #000000;
            margin-top: 0px;
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
                <img src="img/logo.png" alt="Lab" id="imagen">
            </div>
            <div class="encabezado">
               
                    <h1>Informe de Ensayos</h1>
                    <h2>Departamento Provincial Laboratorio</h2>
                    <h3>Dirección Provincial de Salud Ambiental</h3>
                    <h4>Secretaría de Salud</h4>

            </div>
            <div id="logo2">
                <img src="img/escudo.png" alt="Escudo" id="imagen">
            </div>
            <div>
            <hr/>
            </div>
                <table>
                    <tbody>
                        <tr>
                            <td style="width:200px" bgcolor="#596876"align="center"><font color="#fff"><strong>Numero de Muestra: {{$muestra->numero}}</strong></td>
                            <td></td>
                            <td style="width:550px" align="right">Fecha de Impresión: {{date('d/m/Y')}}</td>
                        </tr>
                    </tbody>
                </table>

        </header>
        <br>
        <section>
            <div>


                <table>
                <td style="width:765px" bgcolor="#2183E3"align="center"><font color="#fff"><strong>Datos del Solicitante</strong></td>
                </table>
                <table id="tabla">
                    <tbody>
                        <tr>
                            <td style="width:420px"><strong>Solicitante: </strong>{{$muestra->solicitante->nombre}}</td>
                            <td style="width:400px"><strong>Dirección del Solicitante: </strong>{{$muestra->solicitante->direccion}}</td>
                        </tr>
                        <tr>
                            <td style="width:420px"><strong>Remite: </strong>{{$muestra->remitente->nombre}}</td>
                            <td style="width:400px"><strong>Dirección del Remitente: </strong>{{$muestra->remitente->direccion}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                </table>
                <table>
                <td style="width:765px" bgcolor="#2183E3"align="center"><font color="#fff"><strong>Datos de la muestra</strong></td>
                </table>
                <table id="tabla">
                        <tbody>
                        <tr>
                            <td><strong>Nº certificado cadena de custodia: </strong>{{$muestra->nro_cert_cadena_custodia}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de Entrada: </strong>{{$muestra->entrada}}</td>
                            <td><strong>Matriz: </strong>{{$muestra->matriz}}</td>
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
                            <td><strong>Provincia: </strong>{{$muestra->provincia}}</td>
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
                        @if ($muestra->matriz == 'Agua')
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
                <table>
                <td style="width:765px" bgcolor="#2183E3"align="center"><font color="#fff"><strong>Datos del Análisis</strong></td>
                </table>
                <table id="tabla">
                    <tbody>
                        <tr>
                            <td style="width:300px"><strong>Fecha de inicio de análisis: </strong>{{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_inicio_analisis))}}</td>
                            
                            <td style="width:300px"><strong>Fecha de fin de análisis: </strong>{{$FechaInicio = date("d/m/Y", strtotime($muestra->fecha_fin_analisis))}}</td>
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
                            <th>Ensayo</th>
                            <th>Método</th>
                            <th>Norma/Proced.</th>
                            <th align="center">Resultado</th>
                            <th align="right">Unidades</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($muestra->ensayos as $ensayo)
                        <tr>
                            <td style="width:300px;">{{$ensayo->ensayo}}</td>
                            <td style="width:150px;">{{$ensayo->metodo}}</td>
                            <td style="width:100px;">{{$ensayo->norma_procedimiento}}</td>
                            <td align="center">{{$ensayo->pivot->resultado}}</td>
                            <td align="right">{{$ensayo->unidades}}</td>
                        </tr>
                        @endforeach
                        <br>
                        <br>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <div><strong>Observaciones: </strong>{{$muestra->observaciones}}</div>
        <footer class="pie">
        <div><strong><span style="float:right">ND: No detectable</span></strong></div>
            <br>
            <div class="bottom-footer">
                <p><b>Los resultados consignados se refieren exclusivamente a la muestra recibida y el Laboratorio declina toda responsabilidad por el uso indebido que se hiciere de éste informe. El presente certificado solo puede ser reproducido integramente y con autorización escrita del Laboratorio</b></p>
            <ul class="footer-nav">
                <li>
                    Berwyn 226, Trelew - Chubut, Argentina - Telefono:(+54) 280 4427421/4421011 - Email:lab@gmail.com
                </li>
            </ul>
        </footer>
        <script type="text/php">
if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;
            $pageText = "Página " . $PAGE_NUM . " de " . $PAGE_COUNT;
            $y = 105;
            $x = 280;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
    </body>

</html>