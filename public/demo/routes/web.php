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
Route::get('/admin/remitentes/index', 'RemitenteController@index')->name('remitentes_index'); // listado remitentes
Route::get('/admin/remitentes/create', 'RemitenteController@create')->name('remitentes_create'); // Nuevo remitente
Route::post('/admin/remitentes', 'RemitenteController@store'); // guardar remitente
Route::get('/admin/remitentes/{id}/edit', 'RemitenteController@edit')->name('remitentes_edit'); // editar remitente
Route::post('/admin/remitentes/{id}/edit', 'RemitenteController@update'); // actualizar remitente
Route::get('/admin/remitentes/{id}/delete', 'RemitenteController@destroy'); // eliminar remitente
Route::get('/auth/user', 'UserController@index')->name('usuarios'); // Usuarios
Route::get('/auth/{id}/edit', 'UserController@edit')->name('user_edit'); // editar
Route::post('/auth/{id}/edit', 'UserController@update'); // actualizar
Route::get('/lab/charts/appointments', 'ChartController@appointments'); // reportes
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
Route::resource('analito','AnalitoController'); // agregar analito
Route::post('/lab/muestras/lote', 'MuestraController@batchAction')->name('lote');
Route::get('/lab/muestras/{id}/ht', 'MuestraController@ht')->name('lab_muestras_ht'); // imprimir HT
Route::post('/lab/muestras/index', 'MuestraController@enviar_mail')->name('enviar_mail');
Route::get('/lab/muestras/aceptar/{id}', 'MuestraController@aceptar')->name('aceptar_muestra'); // aceptar muestra
Route::get('/lab/muestras/devolver/{id}', 'MuestraController@devolver')->name('devolver_muestra'); // aceptar muestra
Route::get('/lab/muestras/revisada/{id}', 'MuestraController@revisada')->name('muestra_revisada'); // muestra revisada
Route::get('/lab/muestras/vrevisar/{id}', 'MuestraController@vrevisar')->name('muestra_vrevisar'); // muestra volver revisar
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
Route::get('/dso/remitos/index', 'DsoremitoController@index')->name('dso_remitos_index'); // listado remitos
Route::get('/dso/remitos/create', 'DsoremitoController@create')->name('dso_remitos_create'); // Nuevo remito
Route::post('/dso/remitos', 'DsoremitoController@store'); // guardar remito
Route::get('/dso/remitos/{id}/edit', 'DsoremitoController@edit')->name('dso_remitos_edit'); // editar remito
Route::post('/dso/remitos/{id}/edit', 'DsoremitoController@update'); // actualizar remitos
Route::get('/dso/remitos/{id}/imprimir_remito', 'DsoremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/dso/remitos/{id}/imprimir_remito_firma', 'DsoremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
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
Route::get('/dsb/remitos/index', 'DsbremitoController@index')->name('dsb_remitos_index'); // listado remitos
Route::get('/dsb/remitos/create', 'DsbremitoController@create')->name('dsb_remitos_create'); // Nuevo remito
Route::post('/dsb/remitos', 'DsbremitoController@store'); // guardar remito
Route::get('/dsb/remitos/{id}/edit', 'DsbremitoController@edit')->name('dsb_remitos_edit'); // editar remito
Route::post('/dsb/remitos/{id}/edit', 'DsbremitoController@update'); // actualizar remitos
Route::get('/dsb/remitos/{id}/imprimir_remito', 'DsbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/dsb/remitos/{id}/imprimir_remito_firma', 'DsbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/dsb/remitos/aceptar/{id}', 'DsbremitoController@aceptar')->name('aceptar_remito_dsb'); // aceptar remito
Route::get('/dsb/remitos/rechazar/{id}', 'DsbremitoController@rechazar')->name('rechazar_remito_dsb'); // aceptar remito
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
Route::get('/dsa/facturas/{id}/delete', 'FacturacionController@destroy'); // eliminar remitente
Route::get('factura-list-excel', 'FacturacionController@exportExcel')->name('facturas.excel');
});

//DB
Route::middleware(['db'])->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/notas/index', 'DbnotaController@index')->name('db_notas_index'); // listado notas
Route::get('/notas/create', 'DbnotaController@create')->name('db_notas_create'); // Nueva nota
Route::post('/notas', 'DbnotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DbnotaController@edit')->name('db_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DbnotaController@update'); // actualizar notas
Route::get('/exp/index', 'DbexpController@index')->name('db_exp_index'); // listado expedientes
Route::get('/exp/create', 'DbexpController@create')->name('db_exp_create'); // Nuevo expediente
Route::post('/exp', 'DbexpController@store'); // guardar expediente
Route::get('/exp/{id}/edit', 'DbexpController@edit')->name('db_exp_edit'); // editar expediente
Route::post('/exp/{id}/edit', 'DbexpController@update'); // actualizar expediente
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
Route::post('expediente','DbexpController@expediente')->name('expedientedb'); // agregar nota en remito
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
Route::resource('articulo','ArticuloController'); // agregar artículo
Route::post('/lab/muestras/lote', 'MuestraController@batchAction')->name('lote');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::post('/user/toggle-status/{user}', 'UserController@toggleStatus')->name('user.toggle-status');
Route::get('lab/facturas/index', 'FacturaController@index')->name('facturas_index'); // listado facturas de muestras nuevo
Route::get('/lab/facturas/create', 'FacturaController@create')->name('facturas_create');
Route::get('lab/facturas/create', 'FacturaController@create')->name('facturas_create'); // Nueva factura
Route::post('/lab/facturas', 'FacturaController@store')->name('facturas_store');
Route::post('lab/facturas', 'FacturaController@store'); // guardar factura
Route::get('lab/facturas/{id}/edit', 'FacturaController@edit')->name('facturas_edit'); // editar factura
Route::put('factura/{factura}', 'FacturaController@update')->name('factura.update');
Route::put('lab/facturas/{id}/edit', 'FacturaController@update')->name('factura.update'); //Actualizar datos factura
Route::put('lab/facturas/{id}/carga_factura', 'FacturaController@cargaFactura')->name('factura.carga_factura'); // Cargar archivo de factura
Route::get('lab/facturas/{id}/delete', 'FacturaController@destroy'); // eliminar factura
Route::get('/lab/facturas/{id}/imprimir_factura', 'FacturaController@imprimir_factura')->name('imprimir_factura'); // imprimir factura
Route::get('/lab/facturas/{id}/ver-archivo', 'FacturaController@verArchivo')->name('ver_archivo');
Route::get('factura-list-excel', 'FacturaController@exportExcel')->name('facturasfil.excel');
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

//REDB
Route::get('/redb/index', 'DbredbController@index')->name('db_redb_index'); // listado
Route::get('/redb/{id}/show', 'DbredbController@show')->name('db_redb_show'); // ver muestra
Route::get('/redb/create', 'DbredbController@create')->name('db_redb_create'); // formulario
Route::post('/redb', 'DbredbController@store'); // guardar
Route::get('/redb/{id}/edit', 'DbredbController@edit')->name('db_redb_edit'); // editar
Route::put('/redb/{id}/edit', 'DbredbController@update')->name('db_redb_update'); // actualizar
Route::resource('inspeccion','DbinspeccionController'); // agregar inspeccion
Route::get('/redb/{id}/certificado', 'DbredbController@certificado')->name('certificado'); // imprimir certificado redb
Route::get('/redb/{id}/ver-analisis', 'DbredbController@verANALISIS')->name('verANALISIS');
Route::get('/redb/{id}/ver-memoria', 'DbredbController@verMEMORIA')->name('verMEMORIA');
Route::get('/redb/{id}/ver-contrato', 'DbredbController@verCONTRATO')->name('verCONTRATO');
Route::get('/redb/{id}/ver-hab', 'DbredbController@verHAB')->name('verHAB');
Route::get('/redb/{id}/ver-plano', 'DbredbController@verPLANO')->name('verPLANO');
Route::get('/redb/{id}/dbcategorias', 'DbredbController@getCategorias'); // obtener categorias
Route::delete('/eliminar-opcion/{id}', 'DbredbController@eliminarOpcion')->name('eliminar_rubro');

//RPADB
Route::get('/rpadb/index', 'DbrpadbController@index')->name('db_rpadb_index'); // listado
Route::get('/rpadb/{id}/show', 'DbrpadbController@show')->name('db_rpadb_show'); // ver muestra
Route::get('/rpadb/create', 'DbrpadbController@create')->name('db_rpadb_create'); // formulario
Route::post('/rpadb', 'DbrpadbController@store'); // guardar
Route::get('/rpadb/{id}/edit', 'DbrpadbController@edit')->name('db_rpadb_edit'); // editar
Route::put('/rpadb/{id}/edit', 'DbrpadbController@update')->name('db_rpadb_update'); // actualizar
Route::get('/rpadb/{id}/certificado', 'DbrpadbController@certificado')->name('certificado'); // imprimir certificado rpadb
Route::get('/rpadb/{id}/ver-analisis', 'DbrpadbController@verANALISIS')->name('verANALISISprod');
Route::get('/rpadb/{id}/ver-ing', 'DbrpadbController@verING')->name('verING');
Route::get('/rpadb/{id}/ver-esp', 'DbrpadbController@verESP')->name('verESP');
Route::get('/rpadb/{id}/ver-mono', 'DbrpadbController@verMONO')->name('verMONO');
Route::get('/rpadb/{id}/ver-info', 'DbrpadbController@verINFO')->name('verINFO');
Route::get('/rpadb/{id}/ver-rotulo', 'DbrpadbController@verROTULO')->name('verROTULO');
Route::get('/rpadb/{id}/ver-certenvase', 'DbrpadbController@verCERTENVASE')->name('verCERTENVASE');
Route::get('/rpadb/{id}/ver-pago', 'DbrpadbController@verPAGO')->name('verPAGO');

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