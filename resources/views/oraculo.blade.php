@extends('layouts.app', ['title' => 'Consulta Inteligente'])

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-3">
        <div class="card-body">
            <h4 class="mb-3">🔎 Consulta Inteligente a la Base de Datos</h4>

            <div class="form-group">
                <label for="pregunta">Escriba su consulta en lenguaje natural:</label>
                <textarea id="pregunta" class="form-control" rows="3" placeholder="Ej: ¿Cuántas muestras se analizaron para E. coli en 2024?"></textarea>
                <button class="btn btn-primary mt-3" onclick="realizarConsulta()">
                    <i class="fas fa-robot mr-1"></i> Consultar
                </button>
            </div>

            <div id="resultado" class="mt-4"></div>
            <canvas id="graficoTorta" class="mt-4"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    async function realizarConsulta() {
        const pregunta = document.getElementById('pregunta').value.trim();
        const resultadoElement = document.getElementById('resultado');
        const grafico = document.getElementById('graficoTorta');
        resultadoElement.innerHTML = '<div class="text-muted">Procesando consulta...</div>';

        if (!pregunta) {
            resultadoElement.innerHTML = `<div class="alert alert-warning">Por favor, escriba una consulta.</div>`;
            return;
        }

        try {
            const response = await fetch('/api/consulta-ia', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ pregunta })
            });

            const data = await response.json();

            if (data.error) {
                resultadoElement.innerHTML = `
                    <div class="alert alert-danger"><strong>Error:</strong> ${data.error}</div>
                    ${data.consulta ? `<pre class="bg-light p-2 mt-2 rounded">${data.consulta}</pre>` : ''}
                `;
                return;
            }

            let html = `
                <div class="alert alert-success"><strong>✅ Resultado:</strong><br>${data.explicacion}</div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-2">🧠 Consulta SQL generada:</h6>
                        <pre class="bg-light p-2 rounded">${data.consulta}</pre>
                    </div>
                </div>
            `;

            if (data.resultados.length > 0) {
                html += '<div class="table-responsive mt-3"><table class="table table-bordered"><thead><tr>';
                for (let key in data.resultados[0]) {
                    html += `<th>${key}</th>`;
                }
                html += '</tr></thead><tbody>';
                data.resultados.forEach(row => {
                    html += '<tr>';
                    for (let key in row) {
                        html += `<td>${row[key]}</td>`;
                    }
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
            } else {
                html += '<div class="alert alert-info mt-3">No se encontraron resultados.</div>';
            }

            resultadoElement.innerHTML = html;

            // Renderizar gráfico si hay data
            if (data.labels && data.data && data.labels.length > 0 && data.data.length > 0) {
                renderizarGrafico(data.labels, data.data);
            }

        } catch (error) {
            resultadoElement.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error inesperado:</strong> ${error.message}
                </div>`;
        }
    }

    function renderizarGrafico(labels, values) {
        const ctx = document.getElementById('graficoTorta').getContext('2d');
        const chartExistente = Chart.getChart("graficoTorta");
        if (chartExistente) chartExistente.destroy();

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#E7E9ED', '#7FB3D5'
                    ],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                }
            }
        });
    }
</script>
@endsection