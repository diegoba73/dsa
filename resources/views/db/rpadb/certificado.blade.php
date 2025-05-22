<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado de Inscripción RPADB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 16px;
            margin: 0;
        }

        .bloque {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }

        .bloque h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
            background-color: #f0f0f0;
            padding: 3px;
            border-bottom: 1px solid #ccc;
        }

        .bloque p {
            margin: 2px 0;
        }

        .firma {
            margin-top: 80px;
            text-align: center;
        }

        .firma img {
            width: 100%;
            max-width: 800px;
            height: auto;
        }

        .firma div {
            display: inline-block;
            width: 45%;
            vertical-align: top;
        }

        footer {
            text-align: center;
            font-size: 10px;
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .boton {
            display: none;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ asset('argon/img/brand/escudo.png') }}" alt="Escudo" height="80">
        <h1>Certificado de Inscripción</h1>
        <h2>Registro Provincial de Alimentos Departamento Bromatología (R.P.A.D.B.)</h2>
        <h1><strong>Número de Registro RPADB: 07{{ str_pad($rpadb->numero, 6, '0', STR_PAD_LEFT) }}</strong></h1>

    </header>

    <div class="bloque">
        <h3>Datos del Producto</h3>
        <p><strong>Denominación:</strong> {{$rpadb->denominacion}}</p>
        <p><strong>Nombre Fantasia:</strong> {{$rpadb->nombre_fantasia}}</p>
        <p><strong>Marca:</strong> {{$rpadb->marca}}</p>
        <!-- <p><strong>Rubro:</strong> {{$rpadb->categoria->nombre ?? 'N/A'}}</p> -->
    </div>

    <div class="bloque">
        <h3>Titular del Producto</h3>
        <p><strong>Nombre / Razón Social:</strong> {{$dbempresa->empresa}}</p>
        <p><strong>Domicilio:</strong> {{$dbempresa->domicilio}}</p>
        <p><strong>Localidad:</strong> {{$dbempresa->ciudad}} - {{$dbempresa->provincia}}</p>
    </div>

    <div class="bloque">
        <h3>Elaborador / Establecimiento</h3>
        <p><strong>Nombre / Razón Social:</strong> {{$dbredb->establecimiento}}</p>
        <p><strong>Domicilio:</strong> {{$dbredb->domicilio}} - {{$dbredb->localidad->localidad}} - {{$dbredb->localidad->provincia->provincia}}</p>
        <p><strong>R.E.D.B. Nº:</strong> 07{{ str_pad($dbredb->numero, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="bloque">
        <h3>Datos Administrativos</h3>
        <p><strong>Expediente:</strong> {{ $rpadb->expediente ?? '' }}</p>
        <p><strong>Fecha de emisión:</strong> 
            <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo ucfirst(strftime('%e de %B de %Y')); ?>
        </p>
        <p><strong>Fecha de vencimiento:</strong> {{ \Carbon\Carbon::parse($rpadb->fecha_reinscripcion)->translatedFormat('j \d\e F \d\e Y') }}</p>
    </div>

    <div class="firma">
        <img src="{{ asset('argon/img/brand/firma_db.jpg') }}" alt="Firma">
    </div>

    <footer>
        <p>Berwyn 226, Trelew - Chubut, Argentina - Tel: (+54) 280 4427421 / 4421011 - Email: laboratoriodpsachubut@gmail.com</p>
    </footer>

    <div align="center">
        <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>

</body>
</html>