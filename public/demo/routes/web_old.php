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
Route::get('/dsb/remitos/{id}/imprimir_remito_firma', 'DsbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
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
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
});

//DSO
Route::middleware(['dso'])->prefix('dso')->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/notas/index', 'DsonotaController@index')->name('dso_notas_index'); // listado notas
Route::get('/notas/create', 'DsonotaController@create')->name('dso_notas_create'); // Nueva nota
Route::post('/notas', 'DsonotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DsonotaController@edit')->name('dso_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DsonotaController@update'); // actualizar notas
Route::get('/remitos/index', 'DsoremitoController@index')->name('dso_remitos_index'); // listado remitos
Route::get('/remitos/create', 'DsoremitoController@create')->name('dso_remitos_create'); // Nuevo remito
Route::post('/remitos', 'DsoremitoController@store'); // guardar remito
Route::get('/remitos/{id}/edit', 'DsoremitoController@edit')->name('dso_remitos_edit'); // editar remito
Route::post('/remitos/{id}/edit', 'DsoremitoController@update'); // actualizar remitos
Route::get('/remitos/{id}/imprimir_remito', 'DsoremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/remitos/{id}/imprimir_remito_firma', 'DsoremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
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
Route::middleware(['dsb'])->prefix('dsb')->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/notas/index', 'DsbnotaController@index')->name('dsb_notas_index'); // listado notas
Route::get('/notas/create', 'DsbnotaController@create')->name('dsb_notas_create'); // Nueva nota
Route::post('/notas', 'DsbnotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DsbnotaController@edit')->name('dsb_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DsbnotaController@update'); // actualizar notas
Route::get('/remitos/index', 'DsbremitoController@index')->name('dsb_remitos_index'); // listado remitos
Route::get('/remitos/create', 'DsbremitoController@create')->name('dsb_remitos_create'); // Nuevo remito
Route::post('/remitos', 'DsbremitoController@store'); // guardar remito
Route::get('/remitos/{id}/edit', 'DsbremitoController@edit')->name('dsb_remitos_edit'); // editar remito
Route::post('/remitos/{id}/edit', 'DsbremitoController@update'); // actualizar remitos
Route::get('/remitos/{id}/imprimir_remito', 'DsbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/remitos/{id}/imprimir_remito_firma', 'DsbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/remitos/aceptar/{id}', 'DsbremitoController@aceptar')->name('aceptar_remito_dsb'); // aceptar remito
Route::get('/remitos/rechazar/{id}', 'DsbremitoController@rechazar')->name('rechazar_remito_dsb'); // aceptar remito
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
Route::middleware(['dsa'])->prefix('dsa')->group(function () {
Route::get('/notas/index', 'DsanotaController@index')->name('dsa_notas_index'); // listado notas
Route::get('/notas/create', 'DsanotaController@create')->name('dsa_notas_create'); // Nueva nota
Route::post('/notas', 'DsanotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DsanotaController@edit')->name('dsa_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DsanotaController@update'); // actualizar nota
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/facturas/index', 'FacturacionController@index')->name('dsa_facturas_index'); // listado facturas viejo
Route::get('/facturas/create', 'FacturacionController@create')->name('dsa_facturas_create'); // Nueva factura
Route::post('/facturas', 'FacturacionController@store'); // guardar factura
Route::get('/facturas/{id}/edit', 'FacturacionController@edit')->name('dsa_facturas_edit'); // editar factura
Route::post('/facturas/{id}/edit', 'FacturacionController@update'); // actualizar factura
Route::get('/facturas/{id}/delete', 'FacturacionController@destroy'); // eliminar remitente
Route::get('factura-list-excel', 'FacturacionController@exportExcel')->name('facturas.excel');
});

//DB
Route::middleware(['db'])->group(function () {
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/db/notas/index', 'DbnotaController@index')->name('db_notas_index'); // listado notas
Route::get('/db/notas/create', 'DbnotaController@create')->name('db_notas_create'); // Nueva nota
Route::post('/db/notas', 'DbnotaController@store'); // guardar nota
Route::get('/db/notas/{id}/edit', 'DbnotaController@edit')->name('db_notas_edit'); // editar nota
Route::post('/db/notas/{id}/edit', 'DbnotaController@update'); // actualizar notas
Route::get('/db/exp/index', 'DbexpController@index')->name('db_exp_index'); // listado expedientes
Route::get('/db/exp/create', 'DbexpController@create')->name('db_exp_create'); // Nuevo expediente
Route::post('/db/exp', 'DbexpController@store'); // guardar expediente
Route::get('/db/exp/{id}/edit', 'DbexpController@edit')->name('db_exp_edit'); // editar expediente
Route::post('/db/exp/{id}/edit', 'DbexpController@update'); // actualizar expediente
Route::get('/db/archivo/index', 'DbarchivoController@index')->name('db_archivo_index'); // listado archivo
Route::get('/db/archivo/create', 'DbarchivoController@create')->name('db_archivo_create'); // Nuevo archivo
Route::post('/db/archivo', 'DbarchivoController@store'); // guardar archivo
Route::get('/db/archivo/{id}/edit', 'DbarchivoController@edit')->name('db_archivo_edit'); // editar archivo
Route::post('/db/archivo/{id}/edit', 'DbarchivoController@update'); // actualizar archivo
Route::get('/db/remitos/index', 'DbremitoController@index')->name('db_remitos_index'); // listado remitos
Route::get('/db/remitos/create', 'DbremitoController@create')->name('db_remitos_create'); // Nuevo remito
Route::post('/db/remitos', 'DbremitoController@store'); // guardar remito
Route::get('/db/remitos/{id}/edit', 'DbremitoController@edit')->name('db_remitos_edit'); // editar remito
Route::post('/db/remitos/{id}/edit', 'DbremitoController@update'); // actualizar remitos
Route::get('/db/remitos/{id}/imprimir_remito', 'DbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/db/remitos/{id}/imprimir_remito_firma', 'DbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/db/mesaentrada/index', 'MesaentradaController@index')->name('db_me_index'); // listado Mesa entrada
Route::get('/db/mesaentrada/create', 'MesaentradaController@create')->name('db_me_create'); // Nuevo ingreso
Route::post('/db/mesaentrada', 'MesaentradaController@store'); // guardar ingreso
Route::get('/db/mesaentrada/{id}/edit', 'MesaentradaController@edit')->name('db_me_edit'); // editar ingreso
Route::post('/db/mesaentrada/{id}/edit', 'MesaentradaController@update'); // actualizar ingreso
Route::get('/db/mesaentrada/finalizar/{id}', 'MesaentradaController@finalizar')->name('finalizar'); // finalizar
Route::get('/db/remitos/aceptar/{id}', 'DbremitoController@aceptar')->name('aceptar_remito'); // aceptar remito
Route::get('/db/remitos/rechazar/{id}', 'DbremitoController@rechazar')->name('rechazar_remito'); // aceptar remito
Route::get('db-list-excel', 'MuestraController@exportDbExcel')->name('db.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condiciones', 'AnuarioController@exportCondicion')->name('exportar.condiciones');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');
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

//REDB
Route::get('/db/redb/index', 'DbredbController@index')->name('db_redb_index'); // listado
Route::get('/db/redb/{id}/show', 'DbredbController@show')->name('db_redb_show'); // ver muestra
Route::get('/db/redb/create', 'DbredbController@create')->name('db_redb_create'); // formulario
Route::post('/db/redb', 'DbredbController@store'); // guardar
Route::get('/db/redb/{id}/edit', 'DbredbController@edit')->name('db_redb_edit'); // editar
Route::post('/db/redb/{id}/edit', 'DbredbController@update'); // actualizar

//RPADB
Route::get('/db/rpadb/index', 'DbrpadbController@index')->name('db_rpadb_index'); // listado
Route::get('/db/rpadb/{id}/show', 'DbrpadbController@show')->name('db_rpadb_show'); // ver muestra
Route::get('/db/rpadb/create', 'DbrpadbController@create')->name('db_rpadb_create'); // formulario
Route::post('/db/rpadb', 'DbrpadbController@store'); // guardar
Route::get('/db/rpadb/{id}/edit', 'DbrpadbController@edit')->name('db_rpadb_edit'); // editar
Route::post('/db/rpadb/{id}/edit', 'DbrpadbController@update'); // actualizar

Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/db/notas/index', 'DbnotaController@index')->name('db_notas_index'); // listado notas
Route::get('/db/notas/create', 'DbnotaController@create')->name('db_notas_create'); // Nueva nota
Route::post('/db/notas', 'DbnotaController@store'); // guardar nota
Route::get('/db/notas/{id}/edit', 'DbnotaController@edit')->name('db_notas_edit'); // editar nota
Route::post('/db/notas/{id}/edit', 'DbnotaController@update'); // actualizar notas
Route::get('/db/exp/index', 'DbexpController@index')->name('db_exp_index'); // listado expedientes
Route::get('/db/exp/create', 'DbexpController@create')->name('db_exp_create'); // Nuevo expediente
Route::post('/db/exp', 'DbexpController@store'); // guardar expediente
Route::get('/db/exp/{id}/edit', 'DbexpController@edit')->name('db_exp_edit'); // editar expediente
Route::post('/db/exp/{id}/edit', 'DbexpController@update'); // actualizar expediente
Route::get('/db/archivo/index', 'DbarchivoController@index')->name('db_archivo_index'); // listado archivo
Route::get('/db/archivo/create', 'DbarchivoController@create')->name('db_archivo_create'); // Nuevo archivo
Route::post('/db/archivo', 'DbarchivoController@store'); // guardar archivo
Route::get('/db/archivo/{id}/edit', 'DbarchivoController@edit')->name('db_archivo_edit'); // editar archivo
Route::post('/db/archivo/{id}/edit', 'DbarchivoController@update'); // actualizar archivo
Route::get('/db/remitos/index', 'DbremitoController@index')->name('db_remitos_index'); // listado remitos
Route::get('/db/remitos/create', 'DbremitoController@create')->name('db_remitos_create'); // Nuevo remito
Route::post('/db/remitos', 'DbremitoController@store'); // guardar remito
Route::get('/db/remitos/{id}/edit', 'DbremitoController@edit')->name('db_remitos_edit'); // editar remito
Route::post('/db/remitos/{id}/edit', 'DbremitoController@update'); // actualizar remitos
Route::get('/db/remitos/{id}/imprimir_remito', 'DbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/db/remitos/{id}/imprimir_remito_firma', 'DbremitoController@imprimir_remito_firma')->name('imprimir_remito_firma'); // imprimir remito con firma
Route::get('/db/mesaentrada/index', 'MesaentradaController@index')->name('db_me_index'); // listado Mesa entrada
Route::get('/db/mesaentrada/create', 'MesaentradaController@create')->name('db_me_create'); // Nuevo ingreso
Route::post('/db/mesaentrada', 'MesaentradaController@store'); // guardar ingreso
Route::get('/db/mesaentrada/{id}/edit', 'MesaentradaController@edit')->name('db_me_edit'); // editar ingreso
Route::post('/db/mesaentrada/{id}/edit', 'MesaentradaController@update'); // actualizar ingreso
Route::get('/db/mesaentrada/finalizar/{id}', 'MesaentradaController@finalizar')->name('finalizar'); // finalizar
Route::get('/db/remitos/aceptar/{id}', 'DbremitoController@aceptar')->name('aceptar_remito'); // aceptar remito
Route::get('/db/remitos/rechazar/{id}', 'DbremitoController@rechazar')->name('rechazar_remito'); // aceptar remito
Route::get('db-list-excel', 'MuestraController@exportDbExcel')->name('db.excel');
Route::get('/lab/muestras/{id}/imprimir_resultado_firma', 'MuestraController@imprimir_resultado_firma')->name('imprimir_resultado_firma'); // imprimir resultado con firma
Route::get('/admin/anuario/consulta', 'AnuarioController@consulta')->name('anuario_consulta'); //Consulta anuario
Route::get('/admin/anuario/resultados', 'AnuarioController@resultados')->name('anuario_resultados'); //Resultado anuario
Route::get('exportar-condiciones', 'AnuarioController@exportCondicion')->name('exportar.condiciones');
Route::get('exportar-tipomuestra', 'AnuarioController@exportTipoMuestra')->name('exportar.tipomuestra');
Route::get('exportar-tipoensayo', 'AnuarioController@exportTipoEnsayo')->name('exportar.tipoensayo');
Route::post('/lab/muestras/{id}','MuestraController@condicion')->name('condicion'); 
Route::get('cliente-list-excel', 'MuestraController@exportClienteExcel')->name('cliente.excel');