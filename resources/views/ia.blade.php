@extends('layouts.app', ['title' => 'Consulta Inteligente'])

@section('content')
<div class="container mt-5">
    <h3>Consulta Inteligente a la Base de Datos</h3>
    <div class="form-group">
        <label for="pregunta">Ingrese su consulta en lenguaje natural:</label>
        <textarea id="pregunta" class="form-control" rows="3" placeholder="Ej: ¿Cuántos productos se registraron en 2024?"></textarea>
        <button class="btn btn-primary mt-2" onclick="consultarIA()">Consultar</button>
    </div>

    <div id="resultado" class="mt-4"></div>
</div>

<script>
    async function consultarIA() {
        const pregunta = document.getElementById('pregunta').value;
        const resultado = document.getElementById('resultado');
        resultado.innerHTML = 'Procesando...';

        const response = await fetch('/api/interpretar-consulta', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pregunta })
        });

        const data = await response.json();

        if (data.error) {
            resultado.innerHTML = `<div class="alert alert-danger"><strong>Error:</strong> ${data.error}</div>`;
            return;
        }

        let html = `<h5>Consulta Interpretada</h5>
                    <pre>${JSON.stringify(data.interpreted, null, 2)}</pre>
                    <h5>Resultados:</h5>`;

        if (data.datos.length === 0) {
            html += `<div class="alert alert-warning">No se encontraron resultados.</div>`;
        } else {
            html += '<table class="table table-bordered"><thead><tr>';
            for (let key in data.datos[0]) {
                html += `<th>${key}</th>`;
            }
            html += '</tr></thead><tbody>';
            data.datos.forEach(row => {
                html += '<tr>';
                for (let key in row) {
                    html += `<td>${row[key]}</td>`;
                }
                html += '</tr>';
            });
            html += '</tbody></table>';
        }

        resultado.innerHTML = html;
    }
</script>
@endsection