<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remito de Muestra</title>
    <style>
        @media print { 
        @page { margin: 80px 25px; }
        header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 0px; left: 0px; right: 0px; height: 50px; }
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
        float: left;
        width:50px;
        height:50px;
        }

        #numero{
        margin-top: 40px;
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
        font-size: 12px;
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
        }
        @page { margin: 80px 25px; }
        header { position: fixed; top: 0px; left: 0px; right: 0px; height: 50px; }
        footer { position: fixed; bottom: 0px; left: 0px; right: 0px; height: 50px; }
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
        float: left;
        width:50px;
        height:50px;
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
        margin-top: 40px;
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
        font-size: 10px;
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
        margin-top: 200px;
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
        #firma{
        float: center;
        width:300px;
        height:100px;
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
                <img src="{{ asset('argon/img/brand/escudo.png') }}" alt="Lab" id="imagen">
            </div>
            <div class="encabezado">
               
                    <h1>Remito de Muestra</h1>
                    <h2>Departamento Provincial de Salud Ocupacional</h2>
                    <h3>Dirección Provincial de Salud Ambiental</h3>
                    <h4>Ministerio de Salud</h4>

            </div>
            <div id="numero">
            <hr/>
                <div><span style="float:right">Fecha de Impresión: {{$fecha_hoy}}</span></div>
            </div>
            <table id="tabla">
                <tr>
                <td><strong>{{$dso_remito->remitente->nombre}}</strong></td>
                </tr>
                <tr>
                <td><strong>{{$dso_remito->remitente->contacto}}</strong></td>
                </tr>
                <tr>
                <td><strong>{{$dso_remito->remitente->direccion}}</strong></td>
                </tr>
                <tr>
                <td><strong>{{$dso_remito->remitente->localidad->localidad}} / {{$dso_remito->remitente->localidad->provincia->provincia}}</strong></td>
                </tr>
                <tr>
                <td style="width:150px"></td><td>Me dirijo a usted a fin de remitir adjunto el/los certidicados de la/s siguientes muestras que se detallan a continucación:</td>
                </tr>
                </table>

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
                    @foreach ($dso_remito->muestras as $muestra)
                        <tr>
                            <td style="width:70px;" align="center">{{$muestra->numero}}</td>
                            <td style="width:200px;">{{$muestra->tipomuestra->tipo_muestra}}</td>
                            <td style="width:400px;">{{$muestra->muestra}}</td>
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
                <td>                 
                </td>
                </tr>
                </table>
            </div>
            <div>               
                <table id="tabla">
                <tr>
                <td style="width:150px"> </td><td><strong>Conclusión: </strong><textarea name="conclusion" rows="10" cols="80" style="font-family:Arial, sans-serif; border: none;">{{$dso_remito->conclusion}}</textarea></td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px"><strong>Nota:</strong></td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">Ley Nacional de Higiene y Seguridad en el Trabajo N° 19.587/72, Decreto N° 351/79,</td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">Capítulo 6 - Provisión de Agua Potable.</td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">Artículo 57:</td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">Todo establecimiento deberá contar con provisión y reserva de agua para uso humano (…) y se mantendrán los niveles de calidad de acuerdo a lo establecido en el Artículo 58 y su modificación en Res. N°523/95. Se entiende por agua para uso humano la que se utiliza para beber, higienizarse o preparar alimentos y cumplirá con los requisitos para agua de bebida aprobados por la autoridad competente.</td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">Todo establecimiento en funcionamiento deberá efectuar un análisis bacteriológico semestral y un análisis fisicoquímico anual de todas las aguas que se utilicen, por separado, cuando provengan de distintas fuentes.<td>
                </tr>
                <tr>
                <td style="width:150px"></td><td style="width:600px">De no cumplimentar el agua la calificación APTA para uso humano, el establecimiento será responsable de tomar de inmediato las medidas necesarias para lograrlo (…).<td>
                </tr>
                <tr>
                <td style="width:150px"> </td><td style="width:600px"> Sin más saludo a usted muy atentamente.</td>
                </tr>
                </table>
            </div>
            <div class="row">
            <div class="form-group">
            <br>
            <br>
            <p>Nº de Nota: {{$dso_remito->nro_nota}}/D.S.O.</p>
            </div>
            </div>
        </section>
    </body>

    <br>
    <div align="center">
    <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</html>