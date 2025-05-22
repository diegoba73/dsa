<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido de Compra</title>
    <style>
        @media print { 
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
        margin-bottom: 1%;
        margin-left: 2%;
        margin-right: 2%;
        width:auto;
        height:auto;
        }
        #logo2{
        float: right;
        margin-bottom: 1%;
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
        line-height: 0.5;
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
        font-size: 14px;
        }

        #tablaEnsayo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
        margin-bottom: 1px;
        }
 
        #tablaEnsayo thead{
        padding: 20px;
        background: #2183E3;
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
        margin-bottom: 1%;
        margin-left: 2%;
        margin-right: 2%;
        width:auto;
        height:auto;
        }
        #logo2{
        float: right;
        margin-bottom: 1%;
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
        line-height: 0.5;
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
        font-size: 14px;
        }

        #tablaEnsayo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1px;
        margin-bottom: 1px;
        }
 
        #tablaEnsayo thead{
        padding: 20px;
        background: #2183E3;
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
                <img src="{{ asset('argon/img/brand/escudo.png') }}" target="_blank" alt="Lab" id="imagen">
            </div>
            <div class="encabezado">
               
                    @if ($pedido->departamento_id == 1)
                    <h2>Departamento Provincial Laboratorio</h2>
                    @elseif ($pedido->departamento_id == 2)
                    <h2>Departamento Provincial de Bromatología</h2>
                    @elseif ($pedido->departamento_id == 3)
                    <h2>Departamento Provincial de Saneamiento Básico</h2>
                    @elseif ($pedido->departamento_id == 4)
                    <h2>Departamento Provincial de Salud Ocupacional</h2>
                    @elseif ($pedido->departamento_id == 5)
                    @endif
                    <h3>Dirección Provincial de Salud Ambiental</h3>
                    <h4>Ministerio de Salud</h4>
                    <h4>Berwyn 226 - Trelew - Chubut</h4>

            </div>
        </header>
        <br>
        <section>
        <div class="top-header">
        </div>
        </section>
            <div><span style="float:right">Fecha de Impresión: {{date('d/m/Y')}}</span></div>
        <div>
                    @if ($pedido->departamento_id == 1)
                    <h4>Ing. Germán Marino</h4>
                    <h4>Dirección Provincial de Salud Ambiental</h4>
                    @elseif ($pedido->departamento_id == 2)
                    <h4>Lic. Diego Sabán</h4>
                    <h4>Departamento Provincial de Bromatología</h4>
                    @elseif ($pedido->departamento_id == 3)
                    <h4>Vet. Daniel Brachi</h4>
                    <h4>Departamento Provincial de Saneamiento Básico</h4>
                    @elseif ($pedido->departamento_id == 4)
                    <h4>Ing. Germán Marino</h4>
                    <h4>Dirección Provincial de Salud Ambiental</h4>
                    @elseif ($pedido->departamento_id == 5)
                    <h4>Ing. Germán Marino</h4>
                    <h4>Dirección Provincial de Salud Ambiental</h4>
                    @endif
        </div>
        <section>
            <div>
                <p style="text-indent: 18em;">Me dirijo a usted a fin de solicitar la compra de los siguientes artículos que se detallan a continuación:</p>
            </div>
        </section>
        <section>
            <div>
            <hr/>
                <table id="tablaEnsayo">
                    <thead>
                        <tr id="fv">
                            <th>Item</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio U.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            @foreach ($pedido->reactivos as $reactivo)
                            <tr><td>{{$reactivo->nombre}}</td><td>{{$reactivo->descripcion}}</td><td>{{$reactivo->pivot->cantidad_pedida}}</td><td>$ {{$reactivo->costo}}</td><td>$ {{(($reactivo->pivot->cantidad_pedida)*($reactivo->costo))}}</td></tr>
                            @endforeach
                            @foreach ($pedido->insumos as $insumo)
                            <tr><td>{{$insumo->nombre}}</td><td>{{$insumo->descripcion}}</td><td>{{$insumo->pivot->cantidad_pedida}}</td><td>$ {{$insumo->costo}}</td><td>$ {{(($insumo->pivot->cantidad_pedida)*($insumo->costo))}}</td></tr>
                            @endforeach
                            @foreach ($articulos as $articulo)
                            <tr><td>{{$articulo->item}}</td><td></td><td>{{$articulo->cantidad}}</td><td>$ {{$articulo->precio}}</td><td>$ {{(($articulo->cantidad)*($articulo->precio))}}</td></tr>
                            @endforeach
                            <tr><td></td><td></td><td></td><td><strong>Total Pedido:</strong></td><td><strong>$ {{$totalr + $totali + $totala}}</strong></td></tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <div><strong>Numero de Nota: </strong>{{$pedido->nro_nota}} / 
        @if ($pedido->departamento_id == 1)
                    D.L.
                    @elseif ($pedido->departamento_id == 2)
                    D.B.
                    @elseif ($pedido->departamento_id == 3)
                    D.S.B.
                    @elseif ($pedido->departamento_id == 4)
                    D.S.O.
                    @elseif ($pedido->departamento_id == 5)
                    D.S.A.
                    @endif
        </div>
    </body>
    <br>
    <br>
    <br>
    <br>
    <div align="center">
    <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</html>