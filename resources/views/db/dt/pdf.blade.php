<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet de Dirección Técnica</title>
<style>
    @page {
        size: 85.60mm 53.98mm;
        margin: 0;
    }
    body {
        font-family: Arial, sans-serif;
        line-height: 1.2;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        width: 85.60mm;
        height: 53.98mm;
        position: relative; /* Contexto de posicionamiento */
    }
    .header {
        text-align: center;
        position: absolute;
        top: 2mm; /* Ajusta según sea necesario */
        left: 0;
        right: 0;
        z-index: 2; /* Asegura que el header esté en el frente */
    }
    .header img {
        max-width: 10mm; /* Ajusta el tamaño del escudo */
        max-height: 10mm;
    }
    .header h1 {
        font-size: 8pt;
        margin: 0;
        display: block; /* Asegura que cada título esté en su propia línea */
    }
    .principal {
        font-size: 6pt;
        position: absolute;
        top: 20mm; /* Ajusta la posición de inicio del cuerpo principal */
        left: 5mm; /* Margen izquierdo */
        right: 15mm; /* Margen derecho */
        bottom: 20mm; /* Espacio para el footer */
        z-index: 1; /* Detrás del header */
    }
    .principal img {
        width: 25mm; /* Ajusta según sea necesario */
        height: 30mm;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        vertical-align: top;
        padding: 0;
    }
    .info {
        position: absolute;
        top: 10mm; /* Ajusta la posición de inicio del cuerpo principal */
        left: 5mm; /* Margen izquierdo */
        right: 8mm; /* Margen derecho */
        bottom: 10mm; /* Espacio para el footer */
        z-index: 1; /* Al mismo nivel que el principal */
        page-break-before: always; /* Crea un nuevo página para el reverso del carnet */
    }
    .info h2, .info p {
        font-size: 7pt;
        margin: 0;
        padding: 0;
    }
    .footer {
        margin-top: 10mm; /* Espacio entre el contenido de la info y el footer */
        text-align: center;
        font-size: 6pt;
    }
</style>
</head>
<body>
    <!-- Front side of the carnet -->
    <div class="header">
        <img src="{{ public_path('/argon/img/brand/escudo3.png') }}" alt="Escudo">
        <h1>Departamento Provincial de Bromatología</h1>
        <h1>Dirección Provincial de Salud Ambiental</h1>
    </div>
    <div class="principal">
        <table>
            <tbody>
                <tr>
                    <td style="width: 70%; vertical-align: top;">
                        <p><strong>Director Técnico Nº:</strong> {{ $dt->id }}</p>
                        <p><strong>Dec. 1809/87 Disp. 097/88</strong></p>
                        <p><strong>Nombre:</strong> {{ $dt->nombre }}</p>
                        <p><strong>D.N.I.:</strong> {{ $dt->dni }}</p>
                        <p><strong>Título:</strong> {{ $dt->titulo }}</p>
                        <p><strong>VENCIMIENTO:</strong> {{$FechaVenc = date("d/m/Y", strtotime($dt->fecha_reinscripcion))}}</p>
                    </td>
                    <td style="width: 20%; vertical-align: top; text-align: center;">
                        <img src="{{ storage_path('app/' . $dt->ruta_foto) }}" alt="Foto" style="width: 25mm; height: 30mm;">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Back side of the carnet -->
    <div class="info">
        <h2>Nota:</h2>
        <p>El presente carnet habilita al titular como Director Técnico debiendo cumplir con lo especificado en los artículos 16 y 17 del Código Alimentario Argentino - Ley 18.284/69.</p>
        <div class="footer">
            <p>......................................................</p>
            <p>Lic. Diego A. Saban</p>
            <p>Dpto. de Bromatología</p>
            <p>Dirección de Salud Ambiental</p>
        </div>
    </div>
</body>
</html>
