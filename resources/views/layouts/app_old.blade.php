<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DSA') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link href="{{ asset('css/chosen.min.css') }}" rel="stylesheet">
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @if (Auth::user()->departamento_id == 1)
            @include('layouts.navbars.sidebar')
            @elseif (Auth::user()->departamento_id == 2)
            @include('layouts.navbars.sidebardb')
            @elseif (Auth::user()->departamento_id == 3)
            @include('layouts.navbars.sidebardsb')
            @elseif (Auth::user()->departamento_id == 4)
            @include('layouts.navbars.sidebardso')
            @elseif (Auth::user()->departamento_id == 5)
            @include('layouts.navbars.sidebardsa')
            @elseif (Auth::user()->role_id == 13)
            @include('layouts.navbars.sidebarcliente')
            @elseif (Auth::user()->role_id == 14)
            @include('layouts.navbars.sidebarinstitucion')
            @endif

        @endauth
        
        <div class="main-content bg-primary">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

        <script src="{{ asset('/js/submit.js') }}" ></script>

        <script src="{{ asset('/js/plugins/chosen/chosen.jquery.js') }}" ></script>
        <script src="{{ asset('/js/plugins/chosen/docsupport/init.js') }}" ></script>
        <script src="{{ asset('/js/plugins/chosen/docsupport/prism.js') }}" ></script>
<script>   

$('#editar').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

//Analitos
var analito = button.data('anaanalito') 
var valor_hallado = button.data('anavalor') 
var unidad = button.data('anaunidad') 
var parametro_calidad = button.data('anaparametro') 
var id = button.data('anaid') 
 

var modal = $(this)

//Analitos
modal.find('.modal-body #analito').val(analito);
modal.find('.modal-body #valor').val(valor_hallado);
modal.find('.modal-body #unidad').val(unidad);
modal.find('.modal-body #parametro').val(parametro_calidad);
modal.find('.modal-body #id').val(id);

})

$('#eliminar').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget) 
var id = button.data('anaid') 

var modal = $(this)

modal.find('.modal-body #id').val(id);
})

$('#editarc').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

//Cepa
var id = button.data('cid')
var incubacion = button.data('cincubacion')
var lote = button.data('clote') 
var tsi = button.data('ctsi')
var citrato = button.data('ccitrato') 
var lia = button.data('clia') 
var urea = button.data('curea') 
var sim = button.data('csim')
var esculina = button.data('cesculina')  
var hemolisis = button.data('chemolisis') 
var tumbling = button.data('ctumbling')
var fluorescencia = button.data('cfluorescencia')
var coagulasa = button.data('ccoagulasa') 
var oxidasa = button.data('coxidasa')   
var catalasa = button.data('ccatalasa')
var gram = button.data('cgram') 
var observaciones = button.data('cobservaciones')
   

var modal = $(this)

//Cepa
modal.find('.modal-body #incubacion').val(incubacion);
modal.find('.modal-body #lote').val(lote);
modal.find('.modal-body #tsi').val(tsi);
modal.find('.modal-body #citrato').val(citrato);
modal.find('.modal-body #lia').val(lia);
modal.find('.modal-body #urea').val(urea);
modal.find('.modal-body #sim').val(sim);
modal.find('.modal-body #esculina').val(esculina);
modal.find('.modal-body #hemolisis').val(hemolisis);
modal.find('.modal-body #tumbling').val(tumbling);
modal.find('.modal-body #fluorescencia').val(fluorescencia);
modal.find('.modal-body #coagulasa').val(coagulasa);
modal.find('.modal-body #oxidasa').val(oxidasa);
modal.find('.modal-body #catalasa').val(catalasa);
modal.find('.modal-body #gram').val(gram);
modal.find('.modal-body #observaciones').val(observaciones);

modal.find('.modal-body #id').val(id);
})

//Factura
$('#pagof').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);

    var id = button.data('fid');
    var fecha_pago = button.data('ffecha_pago');

    var modal = $(this);

    modal.find('.modal-body #fecha_pago').val(fecha_pago);
    modal.find('.modal-body #id').val(id);
    
    // Asignar el valor del nombre del archivo al campo oculto
    modal.find('.modal-body #nombre_factura').val(modal.find('.modal-body input[type="file"]').val());
});

//Reactivos
$('#editarsr').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

var hs = button.data('srhs')
var observaciones = button.data('srobservaciones')
var proveedor_id = button.data('srproveedor_id')
var pedido = button.data('srpedido')
var registro = button.data('srregistro')
var id = button.data('srid') 
var entrada = button.data('srentrada') 
var apertura = button.data('srapertura')
var vencimiento = button.data('srvencimiento')  
var baja = button.data('srbaja') 
var contenido = button.data('srcontenido')
var marca = button.data('srmarca')
var grado = button.data('srgrado') 
var lote = button.data('srlote')   
var lugar = button.data('srlugar')
var conservacion = button.data('srconservacion') 
var almacenamiento = button.data('sralmacenamiento') 
var area = button.data('srarea') 
   

var modal = $(this)

//Reactivos
modal.find('.modal-body #hs').val(hs);
modal.find('.modal-body #observaciones').val(observaciones);
modal.find('.modal-body #proveedor_id').val(proveedor_id);
modal.find('.modal-body #pedido').val(pedido);
modal.find('.modal-body #registro').val(registro);
modal.find('.modal-body #entrada').val(entrada);
modal.find('.modal-body #apertura').val(apertura);
modal.find('.modal-body #vencimiento').val(vencimiento);
modal.find('.modal-body #baja').val(baja);
modal.find('.modal-body #contenido').val(contenido);
modal.find('.modal-body #marca').val(marca);
modal.find('.modal-body #grado').val(grado);
modal.find('.modal-body #lote').val(lote);
modal.find('.modal-body #lugar').val(lugar);
modal.find('.modal-body #conservacion').val(conservacion);
modal.find('.modal-body #almacenamiento').val(almacenamiento);
modal.find('.modal-body #area').val(area);

modal.find('.modal-body #id').val(id);
})

$('#editarsi').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

//Insumos
var id = button.data('siid')
var proveedor_id = button.data('siproveedor_id')
var pedido = button.data('sipedido')
var registro = button.data('siregistro')
var entrada = button.data('sientrada')
var baja = button.data('sibaja')
var cantidad = button.data('sicantidad') 
var marca = button.data('simarca')  
var almacenamiento = button.data('sialmacenamiento')
var certificado = button.data('sicertificado') 
var observaciones = button.data('siobservaciones')
var area = button.data('siarea')
   

var modal = $(this)

//Insumos
modal.find('.modal-body #proveedor_id').val(proveedor_id);
modal.find('.modal-body #pedido').val(pedido);
modal.find('.modal-body #registro').val(registro);
modal.find('.modal-body #entrada').val(entrada);
modal.find('.modal-body #baja').val(baja);
modal.find('.modal-body #cantidad').val(cantidad);
modal.find('.modal-body #marca').val(marca);
modal.find('.modal-body #almacenamiento').val(almacenamiento);
modal.find('.modal-body #certificado').val(certificado);
modal.find('.modal-body #observaciones').val(observaciones);
modal.find('.modal-body #area').val(area);

modal.find('.modal-body #id').val(id);
})

$('#eliminarsr').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget) 
var id = button.data('srid') 
var modal = $(this)

modal.find('.modal-body #id').val(id);
})

$('#eliminarsi').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget) 
var id = button.data('siid') 
var modal = $(this)

modal.find('.modal-body #id').val(id);
})

$('#matriz').change(function(e){
    var matriz_id = e.target.value;
    $.get('/lab/muestras/'+matriz_id+'/ensayos', function(data){ 
        $('#ensayos').empty();       
        var html_select = '';

        for (var i = 0; i < data.length; ++i) {
            var ensayo = data[i];
            var option = '<option value="'+ensayo.id+'"';

            if (ensayo.activo) {
                option += '>'; // Opción habilitada para ensayos activos
            } else {
                option += ' disabled>'; // Opción deshabilitada para ensayos inactivos
            }

            option += ensayo.ensayo + ' / ' + ensayo.norma_procedimiento + '</option>';
            html_select += option;
        }

        $('#ensayos').html(html_select);
        $('#ensayos').chosen();
        $('#ensayos').trigger("chosen:updated");   
    });
});


$('#matriz').change(function(e){
    var matriz_id = e.target.value;
    $.get('/lab/muestras/'+matriz_id+'/tipomuestras', function(data){ 
        $('#tipomuestra').empty();       
        var html_select = '';
        for (var i=0; i<data.length; ++i)
        html_select += '<option value="'+data[i].id+'">'+data[i].tipo_muestra+'</option>';
        $('#tipomuestra').html(html_select);
        $('#tipomuestra').chosen();
        $('#tipomuestra').trigger("chosen:updated");   
    });
});

$('#provincia').change(function(e){
    var provincia_id = e.target.value;
    $.get('/lab/muestras/'+provincia_id+'/localidads', function(data){ 
        $('#localidad').empty();       
        var html_select = '';
        for (var i=0; i<data.length; ++i)
        html_select += '<option value="'+data[i].id+'">'+data[i].localidad+'</option>';
        $('#localidad').html(html_select);
        $('#localidad').chosen();
        $('#localidad').trigger("chosen:updated");   
    });
});

		$("#mas").on( "click", function() {

            $('#divmenos').show(); //muestro mediante id
			$('.divmenos').show(); //muestro mediante clase
            $('#divmas').hide(); //muestro mediante id
			$('.divmas').hide(); //muestro mediante clase
		 });
		$("#menos").on( "click", function() {
			$('#divmas').show(); //muestro mediante id
			$('.divmas').show(); //muestro mediante clase
            $('#divmenos').hide(); //muestro mediante id
			$('.divmenos').hide(); //muestro mediante clase

		});

//Factura agrega items del nomenclador y cantidad

$(document).ready(function() {
    $('#nomenclador-select').on('change', function() {
        var selectedNomencladors = $(this).val();
        var tableBody = $('#selected-nomencladors-table tbody');

        tableBody.empty();

        $.each(selectedNomencladors, function(index, value) {
            var row = $('<tr></tr>');
            row.append($('<td></td>').text($('#nomenclador-select option[value="' + value + '"]').text()));
            row.append($('<td></td>').append($('<input type="number" class="form-control" name="nomenclador_cantidades[' + value + ']" placeholder="Cantidad">')));

            tableBody.append(row);
        });
    });


});


</script>
    </body>
</html>