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

$('#editarf').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

//Factura
var id = button.data('fid')
var fecha_pago = button.data('ffecha_pago')
var nombre = button.data('fnombre')
var ruta = button.data('fruta')
   

var modal = $(this)

//Factura
modal.find('.modal-body #fecha_pago').val(fecha_pago);
modal.find('.modal-body #nombre').val(nombre);
modal.find('.modal-body #ruta').val(ruta);

modal.find('.modal-body #id').val(id);
})

$('#editarsr').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) 

//Reactivos
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
        for (var i=0; i<data.length; ++i)
        html_select += '<option value="'+data[i].id+'">'+data[i].ensayo+' / '+data[i].norma_procedimiento+'</option>';
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
//Modificar Exp
$(document).ready(function() {
        $('.editar-exp').click(function() {
            var expid = $(this).data('expid');
            var nro_nota = $(this).data('expnro_nota');
            var nro_expediente = $(this).data('expnro_expediente');
            var descripcion = $(this).data('expdescripcion');
            var fecha_expediente = $(this).data('expfecha_expediente');
            var estado = $(this).data('expestado');
            var observaciones = $(this).data('expobservaciones');
            var costo_total = $(this).data('expcosto_total');

            $('#modificar_exp').find('[name="id"]').val(expid);
            $('#modificar_exp').find('[name="nro_nota"]').val(nro_nota);
            $('#modificar_exp').find('[name="nro_expediente"]').val(nro_expediente);
            $('#modificar_exp').find('[name="descripcion"]').val(descripcion);
            $('#modificar_exp').find('[name="fecha_expediente"]').val(fecha_expediente);
            $('#modificar_exp').find('[name="estado"]').val(estado);
            $('#modificar_exp').find('[name="observaciones"]').val(observaciones);
            $('#modificar_exp').find('[name="costo_total"]').val(costo_total);
        });
    });

</script>
    </body>
</html>