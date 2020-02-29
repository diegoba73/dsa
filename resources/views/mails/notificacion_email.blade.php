<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificación del Laboratorio DSA</title>
</head>
<body>
    @if ($muestra->count() > 1)
    <p>Estimado cliente, se ha realizado el ingreso de las muestras enviadas a nuestro Laboratorio.</p>
    <p>Para el seguimiento de los resultados les enviamos los datos de las mismas:</p>
    <ul>
        @foreach ($muestra as $m)
        <li>Numero de muestra: {{ $m->numero }} / Muestra: {{ $m->muestra }} / Identificación: {{ $m->identificacion}}</li>
        @endforeach
    </ul>
    <p>Estamos en contacto por cualquier duda o consulta. </p>
    <p>Saludos cordiales.</p>
    @else
    <p>Estimado cliente, se ha realizado el ingreso de la muestra enviada a nuestro Laboratorio.</p>
    <p>Para el seguimiento de los resultados les enviamos los datos de la misma:</p>
    <ul>
        @foreach ($muestra as $m)
        <li>Numero de muestra: {{ $m->numero }} / Muestra: {{ $m->muestra }} / Fecha Entrada: {{ $m->fecha_entrada }} / Identificación: {{ $m->identificacion}}</li>
        @endforeach
    </ul>
    <p>Estamos en contacto por cualquier duda o consulta. </p>
    <p>Saludos cordiales.</p>
    @endif
</body>
</html>