<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet Dirección Técnica</title>
    <style>
        @page {
            size: A4 portrait; /* Tamaño de la hoja en formato A4 vertical */
            margin: 10mm; /* Margen para impresión */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 7pt; /* Fuente ajustada */
            margin: 0;
            padding: 0;
        }
        .carnet {
            display: flex;
            flex-direction: row; /* Dividimos en columnas */
            width: 180mm; /* Doble ancho del carnet */
            height: 70mm; /* Altura estándar */
            border: 4px solid #000;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .section {
            width: 50%; /* Cada sección ocupa la mitad del ancho */
            height: 100%; /* Altura completa */
            box-sizing: border-box;
            padding: 3mm;
            border-left: 4px solid #000; /* Línea divisoria */
        }
        .section:first-child {
            border-left: none; /* Eliminar línea en el frente */
        }
        .header {
            text-align: center;
            margin-top: -3mm;
        }
        .header img {
            max-width: 10mm;
            max-height: 10mm;
        }
        .header2 {
            position: relative;
            max-width: 100mm;
            max-height: 50mm;
        }

        .header2 img {
            position: absolute;
            top: -60px;
            left: 0;
            max-width: 100mm;
            max-height: 50mm;
        }
        .header h1, .header h2 {
            margin: 0;
            font-size: 6.5pt; /* Encabezado compacto */
        }
        .content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end; /* <-- Esto alinea verticalmente abajo */
        }
        .content-left {
            width: 70%;
            margin-top: -4mm;
        }
        .content-right {
            padding-bottom: 3mm;
            box-sizing: border-box; /* muy importante para que el padding se respete */
            display: flex;
            align-items: flex-end;
        }

        .content-right img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            border: 1px solid #000;
            margin: 0;
        }
        .info {
            margin-top: 15mm;
        }
        .establecimientos-wrapper {
            margin-top: 0.5mm; /* Subí el bloque completo */
            font-size: 6pt;
        }

        .establecimientos-wrapper h4 {
            margin: 0 0 0mm 0; /* Reducí el espacio inferior del título */
            font-size: 8pt;
            font-weight: bold;
        }

        .establecimientos {
            max-height: 34mm;
            overflow-y: auto;
            margin: 0;
            padding: 0;
        }
        .firma {
            margin-top: auto;
            text-align: center;
            font-size: 6.5pt;
            line-height: 1;
            width: 100%;
            padding-top: 4mm; /* Espacio visual superior */
        }
        @media print {
            .boton {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="carnet">
        <!-- Frente -->
        <div class="section front">
            <div class="header">
                <img src="{{ asset('/argon/img/brand/chubut.png') }}" alt="Logo">
                <h1>Departamento Provincial de Bromatología</h1>
                <h2>Dirección Provincial de Salud Ambiental</h2>
                <h2>Secretaría de Salud - Chubut</h2>
            </div>
            <h3><strong>Director / Asesor Técnico Nº:</strong> 07-{{ str_pad($dt->id, 6, '0', STR_PAD_LEFT) }}</h3>
            <div class="content">
                <div class="content-left">
                    <p><strong>Dec.1809/87 Disp. 097/88</strong></p>
                    <p><strong>Nombre:</strong> {{ $dt->nombre }}</p>
                    <p><strong>DNI:</strong> {{ $dt->dni }}</p>
                    <p><strong>Título:</strong> {{ $dt->titulo }}</p>
                    <p><strong>Dirección:</strong> {{ $dt->domicilio }}</p>
                    <p><strong>Localidad:</strong> {{ $dt->ciudad }}</p>
                    <p ><strong>Vencimiento:</strong> {{ date('d/m/Y', strtotime($dt->fecha_reinscripcion)) }}</p>
                    <p>Trelew, Chubut {{ strftime('%d de %B de %Y', strtotime(now())) }}</p>
                </div>
                <div class="content-right">
                    <img src="{{ route('verFOTO', $dt->id) }}" alt="Foto" style="width: 25mm; height: 30mm;">
                </div>
            </div>
        </div>

        <!-- Reverso -->
        <div class="section back">
            <div class="header2">
            <img src="{{ asset('/argon/img/brand/logo_nuevo.png') }}" alt="Logo">
            </div>
            <div class="info">
                <p><strong>Nota:</strong> El presente carnet habilita al titular como Director Técnico, debiendo cumplir con lo especificado en los artículos 16 y 17 del Código Alimentario Argentino - Ley 18.284/69.</p>
            </div>
            <div class="content">
                <div class="establecimientos-wrapper">
                    <h4>Establecimientos a cargo</h4>
                    <div class="establecimientos">
                        <ul>
                            @foreach($dt->redbs as $redb)
                                <li>Registro {{ $redb->transito }} Nro: 07{{ str_pad($redb->numero, 6, '0', STR_PAD_LEFT) }} - {{ $redb->establecimiento }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="firma" style="line-height: 0.1;">
                <p>......................................................</p>
                <p>Lic. Diego A. Saban</p>
                <p>Dpto. Provincial de Bromatología</p>
                <p>Dirección de Salud Ambiental</p>
            </div>
        </div>
    </div>
    <div align="center">
    <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>
</body>
</html>
