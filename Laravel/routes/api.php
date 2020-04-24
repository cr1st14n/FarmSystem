<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/artF/{id}','admController@fechavencimiento');
Route::get('/articuloStock/{id}','admController@articuloStock');
Route::get('/clenteDatos/{id}','admController@clienteDatos');
Route::get('/detallVenta/{id}','admController@detalleVenta');
Route::get('/clientes/list/','admController@listClientes');
Route::get('/listArticulosAjax/','ArticulosController@ListAjax');
Route::get('/listArticulos/','articulosAjaxController@ListAjax');
Route::get('/buscarArticulosAjax/{valor}','articulosAjaxController@buscarArticulo');
Route::get('/VerArticulosAjax/{valor}','articulosAjaxController@showArticulo');
Route::get('/listProvedores/','ProvAjaxController@listSelect');
Route::get('/listRegistroVentas/','AjaxVentasController@listRegisVentas');
Route::get('/listProvAticulo/','ProvAjaxController@listProvArti1');

//rutas reportes 
	Route::get('/listVentaGeneralSinple/{fecha}','AjaxVentasController@listVentaGeneralFechSimple');
	Route::get('/listVentaGeneralRango/{fecha1}/{fecha2}','AjaxVentasController@listVentaGeneralFechRango');
