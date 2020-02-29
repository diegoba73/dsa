<?php

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
Route::middleware(['auth', 'admin'])->group(function () {
   
	//ADMIN

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
Route::get('/lab/ensayos/index', 'EnsayoController@index')->name('lab_ensayos_index'); // listado ensayos
Route::get('/lab/ensayos/create', 'EnsayoController@create')->name('lab_ensayos_create'); // Nuevo ensayo
Route::post('/lab/ensayos', 'EnsayoController@store'); // guardar ensayo
Route::get('/lab/ensayos/{id}/edit', 'EnsayoController@edit')->name('lab_ensayo_edit'); // editar ensayo
Route::post('/lab/ensayos/{id}/edit', 'EnsayoController@update'); // actualizar ensayo

});




Route::get('/lab/muestras/index', 'MuestraController@index')->name('lab_muestras_index'); // listado
Route::get('/lab/muestras/{id}/show', 'MuestraController@show')->name('lab_muestras_show'); // ver muestra
Route::get('/lab/muestras/create', 'MuestraController@create')->name('lab_muestras_create'); // formulario
Route::post('/lab/muestras', 'MuestraController@store'); // guardar
Route::get('/lab/muestras/{id}/edit', 'MuestraController@edit')->name('lab_muestras_edit'); // editar
Route::post('/lab/muestras/{id}/edit', 'MuestraController@update'); // actualizar
Route::get('/lab/muestras/{id}/ensayos', 'MuestraController@getEnsayos'); // obtener ensayos
Route::get('/lab/muestras/{id}/tipomuestras', 'MuestraController@getTipomuestras'); // obtener tipo de muestras
Route::get('/lab/muestras/{id}/localidads', 'MuestraController@getLocalidades'); // obtener localidades
Route::post('notapedido','DlnotaController@notapedido')->name('notapedido'); // agregar nota en pedido
Route::post('notaremito','DbnotaController@notaremito')->name('notaremito'); // agregar nota en remito
Route::post('notaremitoeditar','DbnotaController@notaremitoeditar')->name('notaremitoeditar'); // agregar nota en remito


Route::middleware(['auth', 'lab'])->group(function () {
//DL

Route::get('/lab/muestras/{id}/frechazo', 'MuestraController@frechazo')->name('lab_muestras_rechazo'); // formulario de rechazo
Route::post('/lab/muestras/{id}/frechazo', 'MuestraController@urechazo'); // actualizar rechazo
Route::get('/lab/muestras/{id}/imprimir_rechazo', 'MuestraController@imprimir_rechazo')->name('imprimir_rechazo'); // imprimir rechazo
Route::get('/lab/muestras/{id}/fresultado', 'MuestraController@fresultado')->name('lab_muestras_resultado'); // formulario de resultado
Route::post('/lab/muestras/{id}/fresultado', 'MuestraController@uresultado'); // actualizar resultado
Route::get('/lab/muestras/{id}/imprimir_resultado', 'MuestraController@imprimir_resultado')->name('imprimir_resultado'); // imprimir resultado
Route::get('/lab/muestras/{id}/imprimir_resultado_traducido', 'MuestraController@imprimir_resultado_traducido')->name('imprimir_resultado_traducido'); // imprimir resultado traducido
Route::resource('analito','AnalitoController'); // agregar analito

Route::get('/lab/muestras/{id}/ht', 'MuestraController@ht')->name('lab_muestras_ht'); // imprimir HT
Route::post('/lab/muestras/index', 'MuestraController@enviar_mail')->name('enviar_mail');
Route::get('/lab/muestras/aceptar/{id}', 'MuestraController@aceptar')->name('aceptar_muestra'); // aceptar muestra
Route::get('/lab/muestras/devolver/{id}', 'MuestraController@devolver')->name('devolver_muestra'); // aceptar muestra
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

});

Route::middleware(['dso'])->prefix('dso')->group(function () {
//DSO

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
});

Route::middleware(['dsb'])->prefix('dsb')->group(function () {
//DSB

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
});

Route::middleware(['dsa'])->prefix('dsa')->group(function () {
//DSA

Route::get('/notas/index', 'DsanotaController@index')->name('dsa_notas_index'); // listado notas
Route::get('/notas/create', 'DsanotaController@create')->name('dsa_notas_create'); // Nueva nota
Route::post('/notas', 'DsanotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DsanotaController@edit')->name('dsa_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DsanotaController@update'); // actualizar nota

Route::get('/facturas/index', 'FacturacionController@index')->name('dsa_facturas_index'); // listado facturas
Route::get('/facturas/create', 'FacturacionController@create')->name('dsa_facturas_create'); // Nueva factura
Route::post('/facturas', 'FacturacionController@store'); // guardar factura
Route::get('/facturas/{id}/edit', 'FacturacionController@edit')->name('dsa_facturas_edit'); // editar factura
Route::post('/facturas/{id}/edit', 'FacturacionController@update'); // actualizar factura
Route::get('/facturas/{id}/delete', 'FacturacionController@destroy'); // eliminar remitente
Route::get('factura-list-excel', 'FacturacionController@exportExcel')->name('facturas.excel');
});

Route::get('/dsa/pedidos/index', 'PedidoController@index')->name('pedido_index'); // listado pedido
Route::get('/dsa/pedidos/create', 'PedidoController@create')->name('pedido_create'); // Nuevo pedido
Route::post('/dsa/pedidos', 'PedidoController@store'); // guardar pedido
Route::get('/dsa/pedidos/{id}/show', 'PedidoController@show')->name('pedido_show'); // mostrar pedido
Route::get('/dsa/pedidos/{id}/edit', 'PedidoController@edit')->name('pedido_edit'); // editar pedido
Route::post('/dsa/pedidos/{id}/edit', 'PedidoController@update')->name('pedido_edit'); // actualizar pedido
Route::get('/dsa/pedidos/{id}/destroy', 'PedidoController@destroy')->name('pedido_destroy'); // eliminar pedido
Route::get('/dsa/pedidos/{id}/imprimir', 'PedidoController@imprimir')->name('imprimir_pedido'); // imprimir pedido

Route::resource('articulo','ArticuloController'); // agregar artículo


Route::middleware(['db'])->prefix('db')->group(function () {
//DB

Route::get('/notas/index', 'DbnotaController@index')->name('db_notas_index'); // listado notas
Route::get('/notas/create', 'DbnotaController@create')->name('db_notas_create'); // Nueva nota
Route::post('/notas', 'DbnotaController@store'); // guardar nota
Route::get('/notas/{id}/edit', 'DbnotaController@edit')->name('db_notas_edit'); // editar nota
Route::post('/notas/{id}/edit', 'DbnotaController@update'); // actualizar notas
Route::get('/remitos/index', 'DbremitoController@index')->name('db_remitos_index'); // listado remitos
Route::get('/remitos/create', 'DbremitoController@create')->name('db_remitos_create'); // Nuevo remito
Route::post('/remitos', 'DbremitoController@store'); // guardar remito
Route::get('/remitos/{id}/edit', 'DbremitoController@edit')->name('db_remitos_edit'); // editar remito
Route::post('/remitos/{id}/edit', 'DbremitoController@update'); // actualizar remitos
Route::get('/remitos/{id}/imprimir_remito', 'DbremitoController@imprimir_remito')->name('imprimir_remito'); // imprimir remito
Route::get('/mesaentrada/index', 'MesaentradaController@index')->name('db_me_index'); // listado Mesa entrada
Route::get('/mesaentrada/create', 'MesaentradaController@create')->name('db_me_create'); // Nuevo ingreso
Route::post('/mesaentrada', 'MesaentradaController@store'); // guardar ingreso
Route::get('/mesaentrada/{id}/edit', 'MesaentradaController@edit')->name('db_me_edit'); // editar ingreso
Route::post('/mesaentrada/{id}/edit', 'MesaentradaController@update'); // actualizar ingreso
Route::get('/db/mesaentrada/finalizar/{id}', 'MesaentradaController@finalizar')->name('finalizar'); // aceptar muestra
});
