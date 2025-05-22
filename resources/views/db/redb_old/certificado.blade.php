<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado de Inscripción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1, header h2, header h3, header h4 {
            margin: 0;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: none; /* Eliminando los bordes de la tabla */
        }

        table td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
            font-size: 18px; /* Aumentando el tamaño del texto en 6 puntos */
        }

        footer {
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 20px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .firmas {
            margin-top: 150px; /* Espacio para las firmas */
        }

        .boton {
            display: none;
        }

        .contenido {
            padding-bottom: 50px; /* Ajuste para dejar espacio para el footer */
        }
    </style>
</head>
<body>
    <div class="contenido">
        <header>
            <!-- Tu escudo aquí -->
            <img class="logo" src="{{ asset('argon/img/brand/escudo.png') }}" alt="Lab">
            <h1>Certificado de Inscripción</h1>
            <h2>Registro de Establecimiento Departamento Bromatología R.E.D.B.</h2>
            <h3>Departamento Provincial de Bromatología</h3>
            <h4>Ministerio de Salud de la Provincia del Chubut</h4>
        </header>

        <table>
            <tr>
                <td><p><strong>Número de Registro R.E.D.B.: 07-000{{$redb->numero}}</strong></p></td>
            </tr>
            <tr>
                <td>Certifícase que el establecimiento de <strong>{{$empresa->empresa}}</strong> con domicilio legal en {{$empresa->domicilio}}, ha sido inscripto y habilitado por la autoridad sanitaria de la provincia de Chubut según Expediente {{$redb->expediente}} cumpliendo con los requisitos establecidos por la Ley Nacional N° 18.284, sus Decretos Reglamentarios, Código Alimentario Argentino, Resoluciones y Disposiciones vigentes.</td>
            </tr>
            <tr>
                <td><strong>Establecimiento: {{$redb->establecimiento}}</strong></td>
            </tr>
            <tr>
                <td><strong>Domicilio: {{$redb->domicilio}} - {{$redb->localidad->localidad}} - {{$redb->localidad->provincia->provincia}}</strong></td>
            </tr>
            <tr>
                <td>Chubut, {{$fechaFormateada}}</td>
            </tr>
            <tr>
                <td><strong>Fecha Vencimiento: {{$FechaVenc = date("d/m/Y", strtotime($redb->fecha_reinscripcion))}}</strong></td>
            </tr>
        </table>

        <!-- Espacio para sellos y firmas triplicado -->
        <div class="firmas">
        <img src="{{ asset('argon/img/brand/firma_db.jpg') }}" alt="Firma" style="width: 100%; max-width: 800px; height: auto;">
        </div>
        <div class="firmas">
            <!-- Aquí puedes colocar tus sellos y firmas -->
        </div>
        <div class="firmas">
            <!-- Aquí puedes colocar tus sellos y firmas -->
        </div>
    </div>

    <footer>
        <p>Berwyn 226, Trelew - Chubut, Argentina - Teléfono: (+54) 280 4427421/4421011 - Email: bromatologiachubut@gmail.com</p>
    </footer>

    <div align="center">
        <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</body>
</html>
