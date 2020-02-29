<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remito de Muestra</title>
    <style>
        @page { margin: 80px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: -70px; left: 0px; right: 0px; height: 50px; }
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
                <img src="argon/img/brand/logo.jpg" alt="Lab" id="imagen">
            </div>
            <div class="encabezado">
               
                    <h1>Remito de Muestra</h1>
                    <h2>Departamento Provincial de Bromatología</h2>
                    <h3>Dirección Provincial de Salud Ambiental</h3>
                    <h4>Ministerio de Salud</h4>

            </div>
            <div id="logo2">
                <img src="argon/img/brand/escudo.png" alt="Escudo" id="imagen">
            </div>
            <div id="numero">
            <hr/>
            </div>
                <table>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="width:730px" align="right">Fecha de Impresión: {{$fecha_hoy}}</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                <tr>
                <td><strong>{{$db_remito->remitente->nombre}}</strong></td>
                </tr>
                <tr>
                <td><strong>{{$db_remito->remitente->contacto}}</strong></td>
                </tr>
                <tr>
                <td><strong>{{$db_remito->remitente->direccion}}</strong></td>
                </tr>
                </table>
                <table>
                <tr>
                <td style="width:150px"> </td><td>Me dirijo a usted a fin de remitir adjunto el/los certidicados de la/s siguientes muestras que se detallan a continucación:</td>
                </tr>
                </table>
                <table id="tabla">

        </header>
        <br>
        <section>
            <div>
                <table id="tablaEnsayo">
                    <thead>
                        <tr id="fv">
                            <th align="center">Número</th>
                            <th>Tipo de Muestra</th>
                            <th>Muestra</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($db_remito->muestras as $muestra)
                        <tr>
                            <td style="width:70px;" align="center">{{$muestra->numero}}</td>
                            <td style="width:150px;">{{$muestra->tipomuestra->tipo_muestra}}</td>
                            <td style="width:500px;">{{$muestra->muestra}}</td>
                        </tr>
                        @endforeach
                        <br>
                        <br>
                    </tbody>
                </table>
                <table>
                <tr>
                <td> </td>
                </tr>
                <tr>
                <td> </td>
                </tr>
                </table>
            </div>
            <div>               
                <table>
                <tr>
                <td style="width:150px"> </td><td><strong>Conclusión: </strong>{{$db_remito->conclusion}}</td>
                </tr>
                <tr>
                <td></td>
                </tr>
                <tr>
                <td style="width:150px"> </td><td> Sin más saludo a usted muy atentamente.
                </tr>
                </table>
            </div>
        </section>

        <br>
        <div></div>
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