@php
    $estado = request($columna);
    if ($estado === '1') {
        $siguiente = '0';
    } elseif ($estado === '0') {
        $siguiente = null;
    } else {
        $siguiente = '1';
    }

    $parametros = request()->except('page', $columna);
    if (!is_null($siguiente)) {
        $parametros[$columna] = $siguiente;
    }

    $url = url()->current() . (count($parametros) ? '?' . http_build_query($parametros) : '');
@endphp

<a href="{{ $url }}" style="color: white; text-decoration: none;" title="Clic para cambiar estado">
    {{ $label }}
    @if ($estado === '1')
        <span class="badge badge-success">✔</span>
    @elseif ($estado === '0')
        <span class="badge badge-danger">✘</span>
    @endif
</a>