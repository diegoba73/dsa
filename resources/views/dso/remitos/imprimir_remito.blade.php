<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Remito de Muestra</title>
        <style>
            @media print {
                @page {
                    margin: 10mm;
                }
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    -webkit-print-color-adjust: exact; /* Permite imprimir colores */
                    margin: 0;
                    padding: 0;
                }
                header {
                    position: relative;
                    text-align: center;
                    margin-bottom: 10mm;
                }
                .tabla-remitente {
                    margin-top: 10mm;
                }
                .boton {
                    display: none !important;
                }
                /* Estilos para impresión de la tabla */
                #tablaEnsayo thead {
                    background-color: #596876 !important;
                    color: #ffffff !important;
                    border-bottom: 1px solid #ffffff;
                }
                #tablaEnsayo tbody tr:nth-child(even) {
                    background-color: #f2f2f2 !important;
                }
                #tablaEnsayo tbody tr:nth-child(odd) {
                    background-color: #ffffff !important;
                }
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            header {
                text-align: center;
                margin-bottom: 20px;
            }

            #logo {
                width: 50px;
                height: 50px;
                margin-bottom: 10px;
            }

            .encabezado h1 {
                font-size: 18px;
                margin: 5px 0;
            }

            .encabezado h2,
            .encabezado h3,
            .encabezado h4 {
                font-size: 14px;
                margin: 2px 0;
            }

            .tabla-remitente {
                width: 100%;
                margin-top: 10px;
                padding: 0;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .tabla-remitente td {
                padding: 5px;
                vertical-align: top;
                text-align: left;
                white-space: nowrap;
            }

            .tabla-remitente .texto {
                text-align: justify;
                margin-top: 10px;
                padding-top: 5px;
                white-space: normal;
            }

            #tablaEnsayo {
                width: 100%;
                border-collapse: collapse;
                margin-top: 5px;
                font-size: 12px;
                page-break-inside: avoid;
            }

            #tablaEnsayo thead {
                font-weight: bold;
                background-color: #596876;
                color: #ffffff;
                border-bottom: 1px solid #ffffff;
            }

            #tablaEnsayo tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #tablaEnsayo tbody tr:nth-child(odd) {
                background-color: #ffffff;
            }

            textarea {
                width: 100%;
                font-family: Arial, sans-serif;
                font-size: 12px;
                border: none;
                resize: none;
            }

            .pie {
                text-align: left;
                font-size: 10px;
                color: #000000;
                margin-top: 20px;
            }

            .boton {
                display: block;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            .boton:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <header>
            <div id="logo">
                <img src="{{ asset('argon/img/brand/escudo.png') }}" alt="Lab">
            </div>
            <div class="encabezado">
                <h1>Remito de Muestra</h1>
                <h2>Departamento Provincial de Salud Ocupacional</h2>
                <h3>Dirección Provincial de Salud Ambiental</h3>
                <h4>Ministerio de Salud</h4>
            </div>
        </header>

        <main>
            <table class="tabla-remitente">
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
                    <td class="texto">
                        <div 
                            style="font-family: Arial, sans-serif; font-size: 12px; line-height: 1.2; white-space: pre-wrap; margin-bottom: 5px;"
                        >
                        Me dirijo a usted a fin de remitir adjunto el/los certificados de la/s siguientes muestras que se detallan a continuación:
                        </div>
                    </td>
                </tr>
            </table>

            <table id="tablaEnsayo">
                <thead>
                    <tr>
                        <td>Número</td>
                        <td>Tipo de Muestra</td>
                        <td>Muestra</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dso_remito->muestras as $muestra)
                        <tr>
                            <td>{{$muestra->numero}}</td>
                            <td>{{$muestra->tipomuestra->tipo_muestra}}</td>
                            <td>{{$muestra->muestra}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table>
                <tr>
                    <td>
                        <strong>Conclusión: </strong>
                        <div 
                            style="font-family: Arial, sans-serif; font-size: 12px; border: none; padding: 5px; box-sizing: border-box; white-space: pre-wrap;"
                        >
                            {{$dso_remito->conclusion}}
                        </div>
                    </td>
                </tr>
                <tr>
                <td><strong>Nota:</strong></td>
                </tr>
                <tr>
                <td>Ley Nacional de Higiene y Seguridad en el Trabajo N° 19.587/72, Decreto N° 351/79,</td>
                </tr>
                <tr>
                <td>Capítulo 6 - Provisión de Agua Potable.</td>
                </tr>
                <tr>
                <td>Artículo 57:</td>
                </tr>
                <tr>
                <td>Todo establecimiento deberá contar con provisión y reserva de agua para uso humano (…) y se mantendrán los niveles de calidad de acuerdo a lo establecido en el Artículo 58 y su modificación en Res. N°523/95. Se entiende por agua para uso humano la que se utiliza para beber, higienizarse o preparar alimentos y cumplirá con los requisitos para agua de bebida aprobados por la autoridad competente.</td>
                </tr>
                <tr>
                <td>Todo establecimiento en funcionamiento deberá efectuar un análisis bacteriológico semestral y un análisis fisicoquímico anual de todas las aguas que se utilicen, por separado, cuando provengan de distintas fuentes.<td>
                </tr>
                <tr>
                <td>De no cumplimentar el agua la calificación APTA para uso humano, el establecimiento será responsable de tomar de inmediato las medidas necesarias para lograrlo (…).<td>
                </tr>
                <tr>
                <td> Sin más saludo a usted muy atentamente.</td>
                </tr>
            </table>
            <div class="pie">
                Nº de Nota: {{$dso_remito->nro_nota}}/D.S.O.
            </div>
        </main>
        <div align="center">
            <button class="boton" onclick="window.print();">Imprimir</button>
        </div>
    </body>
</html>
