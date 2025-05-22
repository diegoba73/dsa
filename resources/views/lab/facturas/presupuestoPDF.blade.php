<!DOCTYPE html>
<html>
<head>
    <title>Presupuesto</title>
    <!-- Estilos CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
        }

        .info table, .info th, .info td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .image-container {
            width: 100%; /* Se ajusta al ancho del contenedor */
            text-align: center; /* Centra la imagen horizontalmente */
            margin-top: -100px; 
            margin-bottom: -100px; /* Añade un margen inferior para separación */
        }

        .logo {
            width: 600px; /* Ajusta el tamaño del logo */
            height: auto; /* Mantiene la proporción de la imagen */
        }
    </style>
</head>
<body>    <!-- Usa una URL de imagen directa para probar -->
    <div class="image-container">
        <img class="logo" src="{{ asset('argon/img/brand/logo_nuevo.png') }}" alt="Lab">
    </div>
    <div class="header">
        <h2>Presupuesto</h2>
    </div>
    <div class="info">
        <table>
            <tr>
                <th>Fecha de Emisión</th>
                <th>Remitente</th>
            </tr>
            <tr>
                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $fechaEmision)->format('d/m/Y') }}</td>
                <td>{{ $remitente }}</td>
            </tr>
        </table>
    </div>
    <div class="detail">
        <h3>Detalles del Presupuesto</h3>
        <table>
            <tr>
                <th>Ítems</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            @php
            $total = 0; // Inicializar la variable total
            @endphp
            @foreach($nomencladoresSeleccionados as $nomenclador)
            <tr>
                <td>{{ $nomenclador->descripcion }}</td>
                <td style="text-align: right;">{{ isset($nomencladorCantidades[$nomenclador->id]) ? $nomencladorCantidades[$nomenclador->id] : '' }}</td>
                <td style="text-align: right;">{{ isset($nomencladorSubtotales[$nomenclador->id]) ? $nomencladorSubtotales[$nomenclador->id] : '' }}</td>
            </tr>
            @php
                $total += isset($nomencladorSubtotales[$nomenclador->id]) ? $nomencladorSubtotales[$nomenclador->id] : 0; // Sumar el subtotal actual al total
            @endphp
            @endforeach
            @foreach($ensayosSeleccionados as $ensayo)
            <tr>
                <td>{{ $ensayo->ensayo }}</td>
                <td style="text-align: right;">{{ $ensayoCantidades[$ensayo->id] ?? '' }}</td>
                <td style="text-align: right;">{{ $ensayoSubtotales[$ensayo->id] ?? '' }}</td>
            </tr>
            @php
                $total += $ensayoSubtotales[$ensayo->id] ?? 0; // Sumar el subtotal actual al total
            @endphp
            @endforeach
        </table>
    </div>
    <div>
        <h3>Total</h3>
        <p>${{ number_format($total, 2) }}</p>
    </div>
    <div>
        <p><strong>Los ensayos podrían eventualmente no llevarse a cabo debido a inconvenientes en la importación y/o reabastecimiento de reactivos.</strong></p>
        <p><strong>Los aranceles se encuentran establecidos conforme al Nomenclador Oficial vigente hasta la fecha. Sin embargo, dichos aranceles pueden sufrir variaciones en sus precios, por futuras modificaciones en los costos.</strong></p>
    </div>
    <div class="footer">
        <p><em>Dirección Provincial de Salud Ambiental - Ministerio de Salud - Provincia del Chubut</em></p>
    </div>
</body>
</html>
