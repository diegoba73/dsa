<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado de Inscripción REDB</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 6px;
            font-size: 13px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ asset('argon/img/brand/escudo.png') }}" alt="Escudo" height="80">
        <h1>Certificado de Inscripción</h1>
        <h2>Registro de Establecimiento - Departamento Bromatología (R.E.D.B.)</h2>
        <h1><strong>Número de Registro REDB: 07{{ str_pad($redb->numero, 6, '0', STR_PAD_LEFT) }}</strong></h1>
    </header>

    <div class="bloque">
        <h3>Datos del Titular</h3>
        <p><strong>Razón Social:</strong> {{$empresa->empresa}}</p>
        <p><strong>Domicilio Legal:</strong> {{$empresa->domicilio}}</p>
        <p><strong>Localidad:</strong> {{$empresa->ciudad ?? ''}}</p>
    </div>

    <div class="bloque">
        <h3>Datos del Establecimiento</h3>
        <p><strong>Nombre del Establecimiento:</strong> {{$redb->establecimiento}}</p>
        <p><strong>Domicilio:</strong> {{$redb->domicilio}} - {{$redb->localidad->localidad}} - {{$redb->localidad->provincia->provincia}}</p>
        <p><strong>Expediente:</strong> {{ $tramite->dbexp->numero ?? '' }}</p>
        <p><strong>Fecha de Vencimiento:</strong> {{ date("d/m/Y", strtotime($redb->fecha_reinscripcion)) }}</p>
    </div>

    <div class="bloque">
        <h3>Rubros, Categorías y Actividades</h3>
        <table>
            <thead>
                <tr>
                    <th>Rubro</th>
                    <th>Categoría</th>
                    <th>Actividad</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($redb->rubros as $rubro)
                    <tr>
                        <td>{{ $rubro->rubro }}</td>
                        <td>
                            @if($rubro->pivot && $rubro->pivot->dbcategoria_id)
                                {{ $categorias->firstWhere('id', $rubro->pivot->dbcategoria_id)->categoria ?? 'Sin categoría' }}
                            @else
                                Sin categoría
                            @endif
                        </td>
                        <td>{{ $rubro->pivot->actividad ?? 'Sin actividad' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No hay datos disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bloque">
        <h3>Fecha y Lugar</h3>
        <p><strong>Chubut, 
            <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo ucfirst(strftime('%e de %B de %Y')); ?>
        </strong></p>
    </div>

    <div class="firma">
        <img src="{{ asset('argon/img/brand/firma_db.jpg') }}" alt="Firma">
    </div>

    <footer>
        <p>Berwyn 226, Trelew - Chubut, Argentina - Tel: (+54) 280 4427421 / 4421011 - Email: bromatologiachubut@gmail.com</p>
    </footer>

    <div align="center">
        <input class="boton" type="button" name="imprimir" value="Imprimir" onclick="window.print();">
    </div>

</body>
</html>