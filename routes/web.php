<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!


|Ruta para ingresar a viejo sitio db
*/
/* Route::get('/db', function () {
    return view('db.inicio');
}); */


Route::get('/', function () {
    return view('inicio');
});
Route::get('/', 'InicioController@index'); // Inicio
Auth::routes();
Route::get('/principal', 'PrincipalController@index')->name('principal');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/dsb/remitos/index', 'DsbremitoController@index')->name('dsb_remitos_index'); // listado remitos
Route::get('/dsb/remitos/create', 'DsbremitoController@create')->name('dsb_remitos_create'); // Nuevo remito
Route::post('/dsb/remitos', 'DsbremitoController@store'); // guardar remito
Route::get('/dsb/remitos/{id}/edit', 'DsbremitoController@edit')->name('dsb_remitos_edit'); // editar remito
Route::post('/dsb/remitos/{id}/edit', 'DsbremitoController@update'); // actualizar remitos
Route::get('/dsb/remitos/{id}/imprimir_remito', 'DsbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/remitos/{id}/imprimir_remito_firma', 'DsbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/dsb/remitos/aceptar/{id}', 'DsbremitoController@aceptar')->name('aceptar_remito_dsb'); // aceptar remito
Route::get('/dsb/remitos/rechazar/{id}', 'DsbremitoController@rechazar')->name('rechazar_remito_dsb'); // aceptar remito
Route::get('/admin/proveedores/index', 'ProveedorController@index')->name('proveedores_index'); // listado proveedores
Route::get('/admin/proveedores/create', 'ProveedorController@create')->name('proveedores_create'); // Nuevo proveedor
Route::post('/admin/proveedores', 'ProveedorController@store'); // guardar proveedor
Route::get('/admin/proveedores/{id}/edit', 'ProveedorController@edit')->name('proveedores_edit'); // editar proveedor
Route::post('/admin/proveedores/{id}/edit', 'ProveedorController@update'); // actualizar proveedor
Route::get('/auth/user', 'UserController@index')->name('usuarios'); // Usuarios
Route::get('/auth/{id}/edit', 'UserController@edit')->name('user_edit'); // editar
Route::post('/auth/{id}/edit', 'UserController@update'); // actualizar
Route::get('exportar-condicionesdb', 'AnuarioController@exportCondiciondb')->name('exportar.condicionesdb');
});

//DL
Route::middleware(['auth', 'lab'])->group(function () {
// Route::get('/lab/muestras/firma', 'MuestraController@firma')->name('lab_muestras_firma'); // firma
// Route::post('/lab/muestras/', 'MuestraController@ufirma')->name('lab_muestras_ufirma'); // actualizar firma
Route::get('/lab/muestras/{id}/frechazo', 'MuestraController@frechazo')->name('lab_muestras_rechazo'); // formulario de rechazo
Route::post('/lab/muestras/{id}/frechazo', 'MuestraController@urechazo'); // actualizar rechazo
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/lab/muestras/{id}/fresultado', 'MuestraController@fresultado')->name('lab_muestras_resultado'); // formulario de resultado
Route::post('/lab/muestras/{id}/fresultado', 'MuestraController@uresultado'); // actualizar resultado
Route::get('/lab/muestras/{id}/imprimir_resultado', 'MuestraController@imprimir_resultado')->name('imprimir_resultado'); // imprimir resultado
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/lab/muestras/{id}/imprimir_traducido', 'MuestraController@imprimir_traducido')->name('imprimir_traducido'); // imprimir resultado traducido
Route::get('/lab/muestras/{id}/imprimir_traducido_firma', 'MuestraController@imprimir_traducido_firma')->name('imprimir_traducido_firma'); // imprimir resultado traducido con firma
Route::resource('analito','AnalitoController'); // agregar analito
Route::post('/lab/muestras/lote', 'MuestraController@batchAction')->name('lote');
Route::get('/lab/muestras/{id}/ht', 'MuestraController@ht')->name('lab_muestras_ht'); // imprimir HT
Route::post('/lab/muestras/index', 'MuestraController@enviar_mail')->name('enviar_mail');
Route::get('/lab/muestras/aceptar/{id}', 'MuestraController@aceptar')->name('aceptar_muestra'); // aceptar muestra
Route::get('/lab/muestras/devolver/{id}', 'MuestraController@devolver')->name('devolver_muestra'); // aceptar muestra
Route::get('/lab/muestras/revisada/{id}', 'MuestraController@revisada')->name('muestra_revisada'); // muestra revisada
Route::get('/lab/muestras/vrevisar/{id}', 'MuestraController@vrevisar')->name('muestra_vrevisar'); // muestra volver revisar
Route::get('/lab/muestras/traducir/{id}', 'MuestraController@traducir')->name('traducir'); // traducir
Route::get('/lab/notas/index', 'DlnotaController@index')->name('lab_notas_index'); // listado notas
Route::get('/lab/notas/create', 'DlnotaController@create')->name('lab_notas_create'); // Nueva nota
Route::post('/lab/notas', 'DlnotaController@store'); // guardar nota
Route::get('/lab/notas/{id}/edit', 'DlnotaController@edit')->name('lab_notas_edit'); // editar nota
Route::post('/lab/notas/{id}/edit', 'DlnotaController@update'); // actualizar notas
Route::get('/lab/reactivos/index', 'ReactivoController@index')->name('lab_reactivos_index'); // listado reactivos
Route::post('/lab/reactivos/imprimir_stock', 'ReactivoController@imprimir_stock')->name('lab_reactivos_imprimir'); // listado reactivos
Route::post('/lab/insumos/imprimir_stock', 'InsumoController@imprimir_stock')->name('lab_insumos_imprimir'); // listado reactivos
Route::get('/lab/reactivos/create', 'ReactivoController@create')->name('lab_reactivos_create'); // Nuevo reactivo
Route::post('/lab/reactivos', 'ReactivoController@store'); // guardar reactivo
Route::get('/lab/reactivos/{id}/edit', 'ReactivoController@edit')->name('lab_reactivos_edit'); // editar reactivo
Route::post('/lab/reactivos/{id}/edit', 'ReactivoController@update'); // actualizar reactivo
Route::get('/lab/reactivos/imprimir_stock', 'ReactivoController@imprimir_stock')->name('imprimir_stock_reactivos'); // imprimir listado stock
Route::get('/lab/insumos/imprimir_stock', 'InsumoController@imprimir_stock')->name('imprimir_stock_insumos'); // imprimir listado stock
Route::resource('stock_reactivo','StockreactivoController'); // agregar Stock Reactivo
Route::get('/dsa/reactivos/{id}/stock', 'ReactivoController@stock')->name('reactivo_stock'); // stock reactivo
Route::resource('stock_insumo','StockinsumoController'); // agregar Stock Insumo
Route::get('/dsa/insumos/{id}/stock', 'InsumoController@stock')->name('insumo_stock'); // stock insumo
Route::get('/lab/insumos/index', 'InsumoController@index')->name('lab_insumos_index'); // listado insumos
Route::get('/lab/insumos/create', 'InsumoController@create')->name('lab_insumos_create'); // Nuevo insumo
Route::post('/lab/insumos', 'InsumoController@store'); // guardar insumo
Route::get('/lab/insumos/{id}/edit', 'InsumoController@edit')->name('lab_insumos_edit'); // editar insumo
Route::post('/lab/insumos/{id}/edit', 'InsumoController@update'); // actualizar insumo
Route::get('/lab/cepario/index', 'MicroorganismoController@index')->name('lab_cepario_index'); // listado cepas
Route::get('/lab/cepario/create', 'MicroorganismoController@create')->name('lab_cepario_create'); // Nuevo cepa
Route::post('/lab/cepario', 'MicroorganismoController@store'); // guardar cepa
Route::get('/lab/cepario/{id}/edit', 'MicroorganismoController@edit')->name('lab_cepario_edit'); // editar cepa
Route::post('/lab/cepario/{id}/edit', 'MicroorganismoController@update'); // actualizar cepa
Route::resource('cepa','CepaController'); // agregar Cepa
Route::get('/dsa/cepario/{id}/cepa', 'MicroorganismoController@cepa')->name('cepa'); // cepario
Route::get('dl-list-excel', 'MuestraController@exportDlExcel')->name('dl.excel');
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condiciones', 'AnuarioController@exportCondicion')->name('exportar.condiciones');
Route::get('exportar-condicionesdb', 'AnuarioController@exportCondiciondb')->name('exportar.condicionesdb');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
});

//DSO
Route::middleware(['dso'])->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/dso/notas/index', 'DsonotaController@index')->name('dso_notas_index'); // listado notas
Route::get('/dso/notas/create', 'DsonotaController@create')->name('dso_notas_create'); // Nueva nota
Route::post('/dso/notas', 'DsonotaController@store'); // guardar nota
Route::get('/dso/notas/{id}/edit', 'DsonotaController@edit')->name('dso_notas_edit'); // editar nota
Route::post('/dso/notas/{id}/edit', 'DsonotaController@update'); // actualizar notas

Route::get('dso-list-excel', 'MuestraController@exportDsoExcel')->name('dso.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condiciones', 'AnuarioController@exportCondicion')->name('exportar.condiciones');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
});

//DSB
Route::middleware(['dsb'])->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/dsb/notas/index', 'DsbnotaController@index')->name('dsb_notas_index'); // listado notas
Route::get('/dsb/notas/create', 'DsbnotaController@create')->name('dsb_notas_create'); // Nueva nota
Route::post('/dsb/notas', 'DsbnotaController@store'); // guardar nota
Route::get('/dsb/notas/{id}/edit', 'DsbnotaController@edit')->name('dsb_notas_edit'); // editar nota
Route::post('/dsb/notas/{id}/edit', 'DsbnotaController@update'); // actualizar notas

Route::get('dsb-list-excel', 'MuestraController@exportDsbExcel')->name('dsb.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condiciones', 'AnuarioController@exportCondicion')->name('exportar.condiciones');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
});

//DSA
Route::middleware(['dsa'])->group(function () {
Route::get('/dsa/notas/index', 'DsanotaController@index')->name('dsa_notas_index'); // listado notas
Route::get('/dsa/notas/create', 'DsanotaController@create')->name('dsa_notas_create'); // Nueva nota
Route::post('/dsa/notas', 'DsanotaController@store'); // guardar nota
Route::get('/dsa/notas/{id}/edit', 'DsanotaController@edit')->name('dsa_notas_edit'); // editar nota
Route::post('/dsa/notas/{id}/edit', 'DsanotaController@update'); // actualizar nota
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/dsa/facturas/index', 'FacturacionController@index')->name('dsa_facturas_index'); // listado facturas viejo
Route::get('/dsa/facturas/create', 'FacturacionController@create')->name('dsa_facturas_create'); // Nueva factura
Route::post('/dsa/facturas', 'FacturacionController@store'); // guardar factura
Route::get('/dsa/facturas/{id}/edit', 'FacturacionController@edit')->name('dsa_facturas_edit'); // editar factura
Route::post('/dsa/facturas/{id}/edit', 'FacturacionController@update'); // actualizar factura
Route::get('/dsa/facturas/{id}/delete', 'FacturacionController@destroy'); // eliminar
Route::get('factura-list-excel', 'FacturacionController@exportExcel')->name('facturas.excel');
Route::get('/dsa/facturas/create', 'FacturacionController@create')->name('dsa_facturas_create'); // Nueva factura
Route::post('/dsa/facturas', 'FacturacionController@store'); // guardar factura
});

//DB
Route::middleware(['db'])->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/notas/index', 'DbnotaController@index')->name('db_notas_index'); // listado notas
Route::get('/notas/create', 'DbnotaController@create')->name('db_notas_create'); // Nueva nota
Route::post('/notas', 'DbnotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DbnotaController@edit')->name('db_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DbnotaController@update'); // actualizar notas
Route::prefix('exp')->group(function () {
    Route::get('/index', 'DbexpController@index')->name('db_exp_index');
    Route::get('/create', 'DbexpController@create')->name('db_exp_create');
    Route::post('/', 'DbexpController@store')->name('db_exp_store');
    Route::get('/{id}/edit', 'DbexpController@edit')->name('db_exp_edit');
    Route::put('/{id}', 'DbexpController@update')->name('db_exp_update');
});
Route::get('/archivo/index', 'DbarchivoController@index')->name('db_archivo_index'); // listado archivo
Route::get('/archivo/create', 'DbarchivoController@create')->name('db_archivo_create'); // Nuevo archivo
Route::post('/archivo', 'DbarchivoController@store'); // guardar archivo
Route::get('/archivo/{id}/edit', 'DbarchivoController@edit')->name('db_archivo_edit'); // editar archivo
Route::post('/archivo/{id}/edit', 'DbarchivoController@update'); // actualizar archivo
Route::get('/remitos/index', 'DbremitoController@index')->name('db_remitos_index'); // listado remitos
Route::get('/remitos/create', 'DbremitoController@create')->name('db_remitos_create'); // Nuevo remito
Route::post('/remitos', 'DbremitoController@store'); // guardar remito
Route::get('/remitos/{id}/edit', 'DbremitoController@edit')->name('db_remitos_edit'); // editar remito
Route::post('/remitos/{id}/edit', 'DbremitoController@update'); // actualizar remitos
Route::get('/remitos/{id}/imprimir_remito', 'DbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/remitos/{id}/imprimir_remito_firma', 'DbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/mesaentrada/index', 'MesaentradaController@index')->name('db_me_index'); // listado Mesa entrada
Route::get('/mesaentrada/create', 'MesaentradaController@create')->name('db_me_create'); // Nuevo ingreso
Route::post('/mesaentrada', 'MesaentradaController@store'); // guardar ingreso
Route::get('/mesaentrada/{id}/edit', 'MesaentradaController@edit')->name('db_me_edit'); // editar ingreso
Route::post('/mesaentrada/{id}/edit', 'MesaentradaController@update'); // actualizar ingreso
Route::get('/mesaentrada/finalizar/{id}', 'MesaentradaController@finalizar')->name('finalizar'); // finalizar
Route::get('/remitos/aceptar/{id}', 'DbremitoController@aceptar')->name('aceptar_remito'); // aceptar remito
Route::get('/remitos/rechazar/{id}', 'DbremitoController@rechazar')->name('rechazar_remito'); // aceptar remito
Route::get('db-list-excel', 'MuestraController@exportDbExcel')->name('db.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condicionesdb', 'AnuarioController@exportCondiciondb')->name('exportar.condicionesdb');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
Route::post('expediente','DbexpController@expediente')->name('expedientedb'); // agregar expediente desde inscripcion redb
});


//Cliente
Route::middleware(['auth', 'cliente'])->group(function () {
	Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
});


Route::get('/dsa/pedidos/index', 'PedidoController@index')->name('pedido_index'); // listado pedido
Route::get('/dsa/pedidos/create', 'PedidoController@create')->name('pedido_create'); // Nuevo pedido
Route::post('/dsa/pedidos', 'PedidoController@store'); // guardar pedido
Route::get('/dsa/pedidos/{id}/show', 'PedidoController@show')->name('pedido_show'); // mostrar pedido
Route::get('/dsa/pedidos/{id}/edit', 'PedidoController@edit')->name('pedido_edit'); // editar pedido
Route::post('/dsa/pedidos/{id}/edit', 'PedidoController@update')->name('pedido_edit'); // actualizar pedido
Route::get('/dsa/pedidos/{id}/destroy', 'PedidoController@destroy')->name('pedido_destroy'); // eliminar pedido
Route::get('/dsa/pedidos/{id}/imprimir', 'PedidoController@imprimir')->name('imprimir_pedido'); // imprimir pedido
Route::get('/dsa/expedientes/index', 'PedidoController@index')->name('dsaexpedientes_index'); // listado pedido
Route::get('/dsa/expedientes/create', 'PedidoController@create')->name('dsaexpedientes_create'); // Nuevo pedido
Route::post('/dsa/expedientes', 'PedidoController@store'); // guardar pedido
Route::get('/dsa/expedientes/{id}/show', 'PedidoController@show')->name('dsaexpedientes_show'); // mostrar pedido
Route::get('/dsa/expedientes/{id}/edit', 'PedidoController@edit')->name('dsaexpedientes_edit'); // editar pedido
Route::post('/dsa/expedientes/{id}/edit', 'PedidoController@update')->name('dsaexpedientes_edit'); // actualizar pedido
Route::get('/dsa/expedientes/{id}/destroy', 'PedidoController@destroy')->name('dsaexpedientes_destroy'); // eliminar pedido
Route::get('/dsa/expedientes/{id}/imprimir', 'PedidoController@imprimir')->name('imprimir_pedido'); // imprimir pedido
Route::get('/exp/index', 'DbexpController@index')->name('db_exp_index'); // listado expedientes
Route::get('/exp/create', 'DbexpController@create')->name('db_exp_create'); // Nuevo expediente
Route::post('/exp', 'DbexpController@store'); // guardar expediente
Route::get('/exp/{id}/edit', 'DbexpController@edit')->name('db_exp_edit'); // editar expediente
Route::post('/exp/{id}/edit', 'DbexpController@update'); // actualizar expediente
Route::post('expediente','DbexpController@expediente')->name('expedientedb'); // agregar expediente desde inscripcion redb
Route::resource('articulo','ArticuloController'); // agregar artículo
Route::post('/lab/muestras/lote', 'MuestraController@batchAction')->name('lote');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::post('/user/toggle-status/{user}', 'UserController@toggleStatus')->name('user.toggle-status');
Route::get('lab/facturas/index', 'FacturaController@index')->name('facturas_index'); // listado facturas de muestras nuevo
Route::get('/lab/facturas/create', 'FacturaController@create')->name('facturas_create');
Route::get('lab/facturas/create', 'FacturaController@create')->name('facturas_create'); // Nueva factura
Route::post('/lab/facturas', 'FacturaController@store')->name('facturas_store');
Route::post('lab/facturas', 'FacturaController@store'); // guardar factura
Route::put('factura/{factura}', 'FacturaController@update')->name('factura.update');
Route::put('lab/facturas/{id}/edit', 'FacturaController@update')->name('factura.update'); //Actualizar datos factura
Route::put('lab/facturas/{id}/carga_factura', 'FacturaController@cargaFactura')->name('factura.carga_factura'); // Cargar archivo de factura
Route::get('lab/facturas/{id}/delete', 'FacturaController@destroy'); // eliminar factura
Route::get('/lab/facturas/{id}/imprimir_factura', 'FacturaController@imprimir_factura')->name('imprimir_factura'); // imprimir factura
Route::get('/lab/facturas/{id}/ver-archivo', 'FacturaController@verArchivo')->name('ver_archivo');
Route::get('factura-list-excel', 'FacturaController@exportExcel')->name('facturasfil.excel');
Route::get('/lab/facturas/presupuesto', 'FacturaController@presupuesto')->name('facturas_presupuesto');
Route::get('lab/facturas/presupuesto', 'FacturaController@presupuesto')->name('facturas_presupuesto'); // Nuevo presupuesto
Route::post('/generar-pdf', 'FacturaController@generarPDF')->name('generar.pdf');
// Ruta para impresión de la factura recién generada
Route::get('/factura/{factura_id}/imprimir', 'FacturaController@imprimirFactura')->name('imprimirFactura');
Route::get('/lab/muestras/index', 'MuestraController@index')->name('lab_muestras_index'); // listado
Route::get('/lab/muestras/{id}/show', 'MuestraController@show')->name('lab_muestras_show'); // ver muestra
Route::get('/lab/muestras/create', 'MuestraController@create')->name('lab_muestras_create'); // formulario
Route::post('/lab/muestras', 'MuestraController@store'); // guardar
Route::get('/lab/muestras/{id}/edit', 'MuestraController@edit')->name('lab_muestras_edit'); // editar
Route::post('/lab/muestras/{id}/edit', 'MuestraController@update'); // actualizar
Route::get('/lab/muestras/{id}/tipomuestras', 'MuestraController@getTipomuestras'); // obtener tipo de muestras
Route::get('/lab/muestras/{id}/localidads', 'MuestraController@getLocalidades'); // obtener localidades
Route::post('notapedido','DlnotaController@notapedido')->name('notapedido'); // agregar nota en pedido
Route::post('notaremito','DbnotaController@notaremito')->name('notaremito'); // agregar nota en remito
Route::post('notaremitoeditar','DbnotaController@notaremitoeditar')->name('notaremitoeditar'); // agregar nota en remito
Route::get('/lab/ensayos/index', 'EnsayoController@index')->name('lab_ensayos_index'); // listado ensayos
Route::get('/lab/ensayos/create', 'EnsayoController@create')->name('lab_ensayos_create'); // Nuevo ensayo
Route::post('/lab/ensayos', 'EnsayoController@store'); // guardar ensayo
Route::get('/lab/ensayos/{id}/edit', 'EnsayoController@edit')->name('lab_ensayo_edit'); // editar ensayo
Route::post('/lab/ensayos/{id}/edit', 'EnsayoController@update'); // actualizar ensayo
Route::get('/lab/muestras/{id}/ensayos', 'MuestraController@getEnsayos'); // obtener ensayos
Route::post('/lab/ensayos/toggle-status/{ensayo}', 'EnsayoController@toggleStatus')->name('ensayo.toggle-status');
Route::post('actualizar_modulo', 'EnsayoController@actualizar_modulo')->name('actualizar_modulo');
Route::get('/lab/muestras/{id}/imprimir_traducido_firma', 'MuestraController@imprimir_traducido_firma')->name('imprimir_traducido_firma'); // imprimir resultado traducido con firma

//EMPRESA
Route::get('/empresa/index', 'DbempresaController@index')->name('db_empresa_index'); // listado
Route::get('/empresa/{id}/show', 'DbempresaController@show')->name('db_empresa_show'); // ver muestra
Route::get('/empresa/create', 'DbempresaController@create')->name('db_empresa_create'); // formulario
Route::post('/empresa', 'DbempresaController@store'); // guardar
Route::get('/empresa/{id}/edit', 'DbempresaController@edit')->name('db_empresa_edit'); // editar
Route::put('/empresa/{id}/edit', 'DbempresaController@update')->name('db_empresa_update'); // actualizar
Route::get('/empresa/{id}/certificado', 'DbempresaController@certificado')->name('certificado'); // imprimir certificado empresa
Route::get('/empresa/{id}/ver-dni', 'DbempresaController@verDNI')->name('verDNI');
Route::get('/empresa/{id}/ver-cuit', 'DbempresaController@verCUIT')->name('verCUIT');
Route::get('/empresa/{id}/ver-estatuto', 'DbempresaController@verESTATUTO')->name('verESTATUTO');

//TRAMITES
Route::get('/tramites/index', 'DbtramiteController@index')->name('db_tramites_index'); // listado
Route::get('/tramites/{id}/show', 'DbtramiteController@show')->name('db_tramites_show'); // ver muestra
Route::delete('/tramites/{id}', 'DbtramiteController@destroy')->name('tramites.destroy');

//REDB
Route::get('/redb/index', 'DbredbController@index')->name('db_redb_index'); // listado
Route::get('/redb/{id}/show_inscripcion', 'DbredbController@show_inscripcion')->name('db_redb_show_inscripcion'); // ver muestra
Route::get('/redb/create_inscripcion', 'DbredbController@create_inscripcion')->name('db_redb_create_inscripcion'); // formulario
Route::post('/redb/inscripcion', 'DbredbController@store_inscripcion')->name('db_redb_store_inscripcion'); // guardar
Route::get('/redb/{id}/edit_inscripcion', 'DbredbController@edit_inscripcion')->name('db_redb_edit_inscripcion'); // editar tramite
Route::put('/redb/{id}/edit_inscripcion', 'DbredbController@update_inscripcion')->name('db_redb_update_inscripcion'); // actualizar tramite
Route::get('/redb/{id}/create_reinscripcion', 'DbredbController@create_reinscripcion')->name('db_redb_create_reinscripcion'); // formulario reinscripcion
Route::post('/redb/{id}/reinscripcion', 'DbredbController@store_reinscripcion')->name('db_redb_store_reinscripcion'); // guardar reinscripcion
Route::get('/redb/{id}/edit_reinscripcion', 'DbredbController@edit_reinscripcion')->name('db_redb_edit_reinscripcion'); // editar reinscripcion
Route::put('/redb/{id}/edit_reinscripcion', 'DbredbController@update_reinscripcion')->name('db_redb_update_reinscripcion'); // actualizar reinscripcion
Route::get('/redb/{id}/show', 'DbredbController@show')->name('db_redb_show'); // ver muestra
Route::get('/redb/{id}/create_modificacion', 'DbredbController@create_modificacion')->name('redb.create_modificacion');
Route::post('/redb/{id}/store_modificacion', 'DbredbController@store_modificacion')->name('db_redb_store_modificacion'); // guardar
Route::post('/redb', 'DbredbController@store_modificacion'); // guardar
Route::get('/redb/{id}/edit_modificacion', 'DbredbController@edit_modificacion')->name('db_redb_edit_modificacion');
Route::put('/redb/{id}/update_modificacion', 'DbredbController@update_modificacion')->name('db_redb_update_modificacion');
//SOLICITAR BAJA
Route::post('/redb/{redb}/solicitar_baja', 'DbredbController@solicitar_baja')->name('solicitar_baja');
// Route::get('/redb/{id}/baja', 'DbredbController@baja')->name('db_redb_baja');
Route::get('/redb/{id}/create_baja', 'DbredbController@create_baja')->name('db_redb_create_baja');
Route::post('/redb/{id}', 'DbredbController@store_baja')->name('redb.store_baja');
// Ruta para mostrar el formulario de edición
Route::get('/redb/{id}/edit_baja', 'DbredbController@edit_baja')->name('db_redb_edit_baja');

Route::resource('inspeccion','DbinspeccionController'); // agregar inspeccion
Route::get('/redb/{id}/certificado', 'DbredbController@certificado')->name('certificado'); // imprimir certificado redb
Route::get('/redb/{id}/ver-analisis', 'DbredbController@verANALISIS')->name('verANALISIS');
Route::get('/redb/{id}/ver-memoria', 'DbredbController@verMEMORIA')->name('verMEMORIA');
Route::get('/redb/{id}/ver-contrato', 'DbredbController@verCONTRATO')->name('verCONTRATO');
Route::get('/redb/{id}/ver-hab', 'DbredbController@verHAB')->name('verHAB');
Route::get('/redb/{id}/ver-plano', 'DbredbController@verPLANO')->name('verPLANO');
Route::get('/redb/{id}/ver-acta', 'DbredbController@verACTA')->name('verACTA');
Route::get('/redb/{id}/ver-pago', 'DbredbController@verPAGO')->name('verPAGO_redb');
Route::get('/redb/{id}/ver-vincdt', 'DbredbController@verVINCDT')->name('verVINCDT');
Route::get('/redb/{id}/dbcategorias', 'DbredbController@getCategorias'); // obtener categorias
Route::delete('/eliminar-opcion/{id}', 'DbredbController@eliminarOpcion')->name('eliminar_rubro');
Route::put('/redbs/{id}/update-dt', 'DbredbController@updateDt')->name('db_redb_update_dt');
Route::get('/redb/{id}/edit', 'DbredbController@edit')->name('redb.edit');
Route::get('/redb/{redb_id}/reinscripcion', 'DbredbController@reinscripcion')->name('reinscripcion_redb');

Route::get('/redb/generarFactura/inscripcion', 'FacturaController@generarFacturaInscripcion')->name('generarFacturaInscripcion');

Route::get('/redb/{redb_id}/generarFactura/modificacion', 'FacturaController@generarFacturaModificacion')->name('generarFacturaModificacion');

Route::get('/redb/{redb_id}/generarFactura/reinscripcion', 'FacturaController@generarFacturaReinscripcion')->name('generarFacturaReinscripcion');

Route::get('/admin/remitentes/index', 'RemitenteController@index')->name('remitentes_index'); // listado remitentes
Route::get('/admin/remitentes/create', 'RemitenteController@create')->name('remitentes_create'); // Nuevo remitente
Route::post('/admin/remitentes', 'RemitenteController@store'); // guardar remitente
Route::get('/admin/remitentes/{id}/edit', 'RemitenteController@edit')->name('remitentes_edit'); // editar remitente
Route::post('/admin/remitentes/{id}/edit', 'RemitenteController@update'); // actualizar remitente
Route::get('/admin/remitentes/{id}/delete', 'RemitenteController@destroy'); // eliminar remitente

//RPADB
Route::get('/rpadb/index', 'DbrpadbController@index')->name('db_rpadb_index'); // listado
Route::get('/rpadb/{id}/show', 'DbrpadbController@show')->name('db_rpadb_show'); // ver muestra
Route::get('/rpadb/create_inscripcion', 'DbrpadbController@create_inscripcion')->name('db_rpadb_create_inscripcion'); // formulario
Route::post('/rpadb/inscripcion', 'DbrpadbController@store_inscripcion')->name('db_rpadb_store_inscripcion'); // guardar
// Ruta para la edición de inscripción de un lote de productos en trámite
Route::get('/rpadb/{id}/edit', 'DbrpadbController@edit')->name('rpadb.edit');
Route::get('/rpadb/{id}/edit_inscripcion', 'DbrpadbController@edit_inscripcion')->name('rpadb.edit_inscripcion');
Route::put('/rpadb/{rpadbId}/update-inscripcion/{tramiteId}', 'DbrpadbController@update_inscripcion')->name('rpadb.update_inscripcion');
Route::get('/rpadb/create_modificacion', 'DbrpadbController@create_modificacion')->name('rpadb.create_modificacion'); // formulario
Route::post('/rpadb/{id}/store_modificacion', 'DbrpadbController@store_modificacion')->name('rpadb.store_modificacion');
Route::get('/rpadb/{id}/edit_modificacion', 'DbrpadbController@edit_modificacion')->name('rpadb.edit_modificacion'); // editar
Route::put('/rpadb/{id}/update_modificacion', 'DbrpadbController@update_modificacion')->name('rpadb.update_modificacion');
Route::get('/rpadb/create_reinscripcion', 'DbrpadbController@create_reinscripcion')->name('rpadb.create_reinscripcion');// Iniciar trámite de reinscripción
Route::post('/rpadb/{id}/store_reinscripcion', 'DbrpadbController@store_reinscripcion')->name('rpadb.store_reinscripcion');// Guardar reinscripción
Route::get('/rpadb/{id}/edit_reinscripcion', 'DbrpadbController@edit_reinscripcion')->name('rpadb.edit_reinscripcion');// Editar trámite en curso
Route::put('/rpadb/{id}/update_reinscripcion', 'DbrpadbController@update_reinscripcion')->name('rpadb.update_reinscripcion');// Actualizar trámite de reinscripción
Route::get('/rpadb/{id}/certificado', 'DbrpadbController@certificado')->name('certificado'); // imprimir certificado rpadb
Route::get('/rpadb/{id}/monografia/{filename}', 'DbrpadbController@verMonografia');
Route::get('/envase/{id}/rotulo', 'DbrpadbController@verRotuloEnvase');
Route::get('/rpadb/{id}/analisis/{filename}', 'DbrpadbController@verAnalisis');
Route::get('/rpadb/{id}/especificaciones/{filename}', 'DbrpadbController@verEspecificaciones');
Route::get('/rpadb/{id}/pago/{filename}', 'DbrpadbController@verPago');
Route::get('/envase/{id}/certificado', 'DbrpadbController@verCERTENVASE');
Route::get('/rpadb/{id}/edit', 'DbrpadbController@edit')->name('rpadb.edit');
/* Route::get('/rpadb/generarFactura/inscripcion', 'FacturaController@generarFacturaInscripcionRpadb')->name('generarFacturaInscripcionRpadb');
Route::get('/rpadb/{rpadb_id}/generarFactura/modificacion', 'FacturaController@generarFacturaModificacionRpadb')->name('generarFacturaModificacionRpadb');
Route::get('/rpadb/{rpadb_id}/generarFactura/reinscripcion', 'FacturaController@generarFacturaReinscripcionRpadb')->name('generarFacturaReinscripcionRpadb'); */
// Iniciar solicitud de baja (desde el botón en el index de productos)
Route::post('/rpadb/{rpadb}/solicitar_baja', 'DbrpadbController@solicitar_baja')->name('rpadb.solicitar_baja');
// Mostrar formulario para registrar la baja (solo NIVEL CENTRAL o ADMIN)
Route::get('/rpadb/{id}/create_baja', 'DbrpadbController@create_baja')->name('rpadb.create_baja');
// Guardar efectivamente la baja
Route::post('/rpadb/{id}/store_baja', 'DbrpadbController@store_baja')->name('rpadb.store_baja');
Route::post('/rpadb/{id}/aprobar_baja', 'DbrpadbController@aprobar_baja')->name('rpadb.aprobar_baja');
Route::post('/rpadb/{id}/evaluar_baja', 'DbrpadbController@evaluar_baja')->name('rpadb.evaluar_baja');
Route::get('/rpadb/{id}/show', 'DbrpadbController@show')->name('rpadb.show');


//INSPECCIONES
Route::get('/inspecciones/index', 'DbinspeccionController@index')->name('db_inspeccion_index'); // listado
Route::get('/inspecciones/{id}/show', 'DbinspeccionController@show')->name('db_inspeccion_show'); // ver muestra
Route::get('/inspecciones/create', 'DbinspeccionController@create')->name('db_inspeccion_create'); // formulario
Route::post('/inspecciones', 'DbinspeccionController@store'); // guardar
Route::get('/inspecciones/{id}/edit', 'DbinspeccionController@edit')->name('db_inspeccion_edit'); // editar
Route::put('/inspecciones/{id}/edit', 'DbinspeccionController@update')->name('db_inspeccion_update'); // actualizar

//HISTORIAL
Route::get('/historial/index', 'DbhistorialController@index')->name('db_historial_index'); // listado
Route::get('/historial/{id}/show', 'DbhistorialController@show')->name('db_historial_show'); // ver muestra
Route::get('/historial/create', 'DbhistorialController@create')->name('db_historial_create'); // formulario
Route::post('/historial', 'DbhistorialController@store'); // guardar
Route::get('/historial/{id}/edit', 'DbhistorialController@edit')->name('db_historial_edit'); // editar
Route::put('/historial/{id}/edit', 'DbhistorialController@update')->name('db_historial_update'); // actualizar

// BAJA
Route::get('/baja/index', 'DbbajaController@index')->name('db_baja_index'); // Listado bajas
Route::get('/baja/create', 'DbbajaController@create')->name('db_baja_create'); // Formulario de creación
Route::post('/baja', 'DbbajaController@store')->name('db_baja_store'); // Guardar baja
Route::get('/baja/{id}/edit', 'DbbajaController@edit')->name('db_baja_edit'); // Formulario de edición
Route::put('/baja/{id}', 'DbbajaController@update')->name('db_baja_update'); // Actualizar baja

//DT
Route::get('/dt/index', 'DbdtController@index')->name('db_dt_index'); // listado
Route::get('/dt/create', 'DbdtController@create')->name('db_dt_create'); // formulario
Route::get('/dt/{id}', 'DbdtController@show')->name('db_dt_show');
Route::get('/dt/{id}/pdf', 'DbdtController@generatePDF')->name('db_dt_pdf');
Route::post('/dt', 'DbdtController@store')->name('dt_store');
Route::get('/dt/{id}/edit', 'DbdtController@edit')->name('db_dt_edit'); // editar
Route::put('/dt/{id}/edit', 'DbdtController@update')->name('db_dt_update'); 
Route::get('/dt/{id}/ver-dni', 'DbdtController@verDNI')->name('verDNI');
Route::get('/dt/{id}/ver-titulo', 'DbdtController@verTITULO')->name('verTITULO');
Route::get('/dt/{id}/ver-cv', 'DbdtController@verCV')->name('verCV');
Route::get('/dt/{id}/ver-cert', 'DbdtController@verCERT')->name('verCERT');
Route::get('/dt/{id}/ver-antecedente', 'DbdtController@verANTECEDENTE')->name('verANTECEDENTE');
Route::get('/dt/{id}/ver-arancel', 'DbdtController@verARANCEL')->name('verARANCEL');
Route::get('/dt/{id}/ver-foto', 'DbdtController@verFOTO')->name('verFOTO');

Route::get('/dso/remitos/index', 'DsoremitoController@index')->name('dso_remitos_index'); // listado remitos
Route::get('/dso/remitos/create', 'DsoremitoController@create')->name('dso_remitos_create'); // Nuevo remito
Route::post('/dso/remitos', 'DsoremitoController@store'); // guardar remito
Route::get('/dso/remitos/{id}/edit', 'DsoremitoController@edit')->name('dso_remitos_edit'); // editar remito
Route::post('/dso/remitos/{id}/edit', 'DsoremitoController@update'); // actualizar remitos
Route::get('/dso/remitos/{id}/imprimir_remito', 'DsoremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/dso/remitos/{id}/imprimir_remito_firma', 'DsoremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma

Route::get('/dsb/remitos/index', 'DsbremitoController@index')->name('dsb_remitos_index'); // listado remitos
Route::get('/dsb/remitos/create', 'DsbremitoController@create')->name('dsb_remitos_create'); // Nuevo remito
Route::post('/dsb/remitos', 'DsbremitoController@store'); // guardar remito
Route::get('/dsb/remitos/{id}/edit', 'DsbremitoController@edit')->name('dsb_remitos_edit'); // editar remito
Route::post('/dsb/remitos/{id}/edit', 'DsbremitoController@update'); // actualizar remitos
Route::get('/dsb/remitos/{id}/imprimir_remito', 'DsbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/dsb/remitos/{id}/imprimir_remito_firma', 'DsbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/dsb/remitos/aceptar/{id}', 'DsbremitoController@aceptar')->name('aceptar_remito_dsb'); // aceptar remito
Route::get('/dsb/remitos/rechazar/{id}', 'DsbremitoController@rechazar')->name('rechazar_remito_dsb'); // aceptar remito
Route::get('/test', function () {
    return 'Laravel está funcionando';
});
Route::get('/oraculo', function () {
    return view('oraculo');
});
Route::get('/nomenclador/por-departamento', 'MuestraController@getNomencladorPorDepartamento')->name('nomenclador.departamento');