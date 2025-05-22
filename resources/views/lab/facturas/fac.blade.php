<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket {{$factura->id}}</title>
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
                <img class="logo" src="{{ asset('argon/img/brand/chubut.png') }}" alt="Lab">
            </div>
            <div class="encabezado">
            @if($factura->departamentos_id == 1)
                <h1>Departamento Provincial de Laboratorio</h1>
            @elseif($factura->departamentos_id == 2)
                <h1>Departamento Provincial de Bromatología</h1>
            @elseif($factura->departamentos_id == 3)
                <h1>Departamento Provincial de Saneamiento Básico</h1>
            @elseif($factura->departamentos_id == 4)
                <h1>Departamento Provincial de Salud Ocupacional</h1>
            @endif
                <h2>Dirección Provincial de Salud Ambiental</h2>
                <h3>Ministerio de Salud</h3>
            </div> 
        </header>
        <div id="numero">
            <hr/>
                    <div style="float:left;"><p><strong>Ticket: {{$factura->id}}</strong></p></div>
                    <div style="float:right;"><p>Fecha de Impresión: {{date('d/m/Y')}}</p></div>     
                            
        </div>
        <section>
        
            <div>  

                <table id="tabla">
                        <tbody>
                        <tr>
                            <td><strong>Cliente: </strong>{{$factura->remitente->nombre}}</td>
                            <td><strong>Fecha de vencimiento: </strong>{{$FechaVenc = date("d/m/Y", strtotime($factura->fecha_vencimiento))}}</td>
                        </tr>

                        </tbody>
                </table>
                <table id="tabla_titulo">
                <tr>
                <th></th>
                <th class="titulo" style="width:765px" align="center"><font color="#fff"><strong>Detalle</strong></th>
                <th></th>
                </tr>
                </table>
            </div>
        </section>
        @if($factura->muestra == 1)
        <section>
            <div>
            <hr/>
            
            <table id="tablaEnsayo">
                <thead>
                    <tr id="fv">
                        <th>Número</th>
                        <th align="left">Muestra</th>
                        <th align="left">Identificación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($muestras as $muestra)
                        <tr>
                            <td>{{ $muestra->numero }}</td>
                            <td align="left">{{ $muestra->muestra }}</td>
                            <td align="left">{{ $muestra->identificacion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                

                <table id="tablaEnsayo">
                    <thead>
                        <tr id="fv">
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th align="left">Precio unitario</th>
                            <th align="right">Precio final</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($ensayos as $ensayo_id => $datos_ensayo)
                        <tr>
                            <td style="width:400px;">{{ $datos_ensayo['ensayo'] }}</td>
                            <td style="width:150px;">{{ $datos_ensayo['cantidad'] }}</td>
                            <td align="left">${{ $datos_ensayo['costo'] }}</td>
                            <td align="right">${{ $datos_ensayo['cantidad'] * $datos_ensayo['costo'] }}</td>
                        </tr>
                    @endforeach
                    @foreach ($factura->nomencladors as $nomenclador)
                    <tr>
                        <td align="left">{{ $nomenclador->descripcion }}</td>
                        <td align="left">{{ $nomenclador->pivot->cantidad }}</td>
                        <td align="left">${{ $nomenclador->valor }}</td>
                        <td align="right">${{ $nomenclador->pivot->subtotal }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><strong>TOTAL: ${{ $factura->total }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @elseif($factura->muestra == 0)
        <section>
            <div>
            <hr/>
            
            <table id="tablaEnsayo">
                <thead>
                    <tr id="fv">
                        <th>Item</th>
                        <th align="center">Cantidad</th>
                        <th align="center">Precio unitario</th>
                        <th align="right">Precio final</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($factura->nomencladors as $nomenclador)
                    <tr>
                        <td>{{ $nomenclador->descripcion }}</td>
                        <td align="center">{{ $nomenclador->pivot->cantidad }}</td>
                        <td align="center">${{ $nomenclador->valor }}</td>
                        <td align="right">${{ $nomenclador->pivot->subtotal }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>TOTAL: ${{ $factura->total }}</strong></td>
                    </tr>
                </tbody>
            </table>              
            </div>
        </section>
        @endif
        <section>
            <table>
                <tbody>
                <tr>
                    <td><strong>El ticket puede ser abonado por TRANSFERENCIA BANCARIA a la siguiente cuenta:</strong></td>
                </tr>    
                <tr>
                    <td>Cta. Cte. Banco del Chubut</td>

                </tr>    
                    <td>CBU: 0830021807002242570012</td>
                <tr>
                </tr>
                <tr>
                    <td>CUIT: 30-99922146-3</td>
                </tr>    
                <tr>    
                    <td><strong>NO MERCADOPAGO, NO RAPIPAGO, NO PAGO FACIL</strong></td>
                </tr>
                <tr>
                    <td><strong>RECORDAR PAGAR EL TICKET DENTRO DE LOS 15 DIAS DE EMITIDO EL MISMO, EVITE INCONVENIENTES Y RETRASOS.</strong></td>
                </tr>
                @if($factura->departamentos_id == 2)
                <tr>
                    <td><strong>Una vez abonado, remitir a este Departamento vía correo electrónico a bromatologiachubut@gmail.com, copia del comprobante del banco.</strong>
                    </td>
                </tr>
                @elseif($factura->departamentos_id == 3)
                <tr>
                    <td><strong>Una vez abonado, remitir a este Departamento vía correo electrónico a saneamientobasicochubut@gmail.com, copia del comprobante del banco.</strong>
                    </td>
                </tr>
                @elseif($factura->departamentos_id == 4)
                <tr>
                    <td><strong>Una vez abonado, remitir a este Departamento vía correo electrónico a saludambientalpm@gmail.com, copia del comprobante del banco.</strong>
                    </td>
                </tr>
                @elseif (($factura->departamentos_id == 5) || ($factura->departamentos_id == 1))
                <tr>
                    <td><strong>Una vez abonado, enviar a éste correo electrónico: dirprosaludambiental@gmail.com, copia del comprobante del banco.</strong>
                    </td>
                </tr>
                @endif
                </tbody>
            </table>  
        </section>
        <footer class="pie">
            <p><b>Berwyn 226, Trelew - Chubut, Argentina - Telefono:(+54) 280 4427421/4421011</b></p>
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