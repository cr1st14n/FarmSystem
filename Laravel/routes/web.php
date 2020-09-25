<?php
//------  Rutas para el Login--------------//
Route::get('/','Auth\LoginController@showLoginForm');
Route::post('/loginFarm','Auth\LoginController@login')->name('loginFarm');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/modelo', function()
{
	 return view('modelo');
}
)->name('modelo');


Route::get('123','HomeController@cont123');


//rutas para modulos e administracion
Route::group(['prefix' => '/Adm'], function(){
	Route::get('/home','HomeController@indexAdm')->name('home-administracion');
		Route::group(['prefix' => '/users'], function(){
			Route::get('/list','UsuariosController@index')->name('usuarios-index');
			Route::get('/list1','UsuariosController@listAllUser');
			Route::post('/createUser','UsuariosController@create')->name('crear-usuario');
			Route::get('/edit','UsuariosController@edit')->name('editar-usuario');
			Route::post('/update','UsuariosController@update')->name('actualizar-usuario');
			Route::post('/updatePerfil','UsuariosController@update2')->name('actualizarPerfil-usuario');
			Route::post('/destroy','UsuariosController@destroy');
			Route::get('/acceso/{id}','UsuariosController@acceso')->name('acceso-usuario');
			Route::get('/perfil','UsuariosController@perfil')->name('perfil-usuario');
			Route::any('/resetContraseña','UsuariosController@resetKey')->name('resetKey-usuario');
			Route::any('/resetPassword1ADM/{ci}','UsuariosController@resetPasword')->name('reset-password');
			Route::post('resetKey1','UsuariosController@resetKey1');
		});
		Route::group(['prefix' => '/AlmInven'], function(){
			Route::get('/list','ArticulosController@index')->name('AlmInven-index');
			Route::post('/createArt','ArticulosController@create')->name('crear-art');
			Route::post('/update','ArticulosController@update')->name('update-art');
			Route::get('/destroyArt/{id}','ArticulosController@destroy')->name('destroy.articulo');
			Route::get('listArticulosAjax','ArticulosController@ListAjax');
		/*------new vercion*/
            Route::get('/home','artInvController@index')->name('AI_home');
            Route::get('/store','artInvController@store');
			Route::get('/storeStock','artInvController@storeStock');
			Route::post('/updateV2','ArticulosController@updateV2');
		});
		Route::group(['prefix' => '/proveedor'], function(){
			Route::get('','ProvedoresController@index')->name('proveedor-index');
			Route::get('/list','ProvedoresController@list');
			Route::post('/createArt','ProvedoresController@create')->name('crear-proveedor');
			Route::get('/edit','ProvedoresController@edit');
			Route::post('/update','ProvedoresController@update');
			Route::post('/destroy','ProvedoresController@destroy');
			// Route::get('/destroyProv/{id} ','ProvedoresController@destroy')->name('destroy-proveedor');
		});
		Route::group(['prefix' => '/stock'], function(){
			Route::get('/list','StockController@index')->name('stock-index');
            Route::post('/agregar','StockController@agregar')->name('agregar-stock');
            Route::post('/sustraer','StockController@sustraer')->name('sustraer-stock');

        //new vercion
            Route::post('/agregarCant','artInvController@agregarCant');
            Route::post('/sustraerCant','artInvController@sustraerCant');
            Route::get('/storeProv/{pro}','artInvController@storePro');
            Route::get('/storeNonCNomG/{nom}','artInvController@storeNonCNomG');
			Route::post('/storeNomG','artInvController@storeNomG');
			Route::post('/storeNomC','artInvController@storeNomC');
            Route::get('/storeAcTe/{at}','artInvController@storeAcTe');
            Route::get('/storeLiMa/{at}','artInvController@storeLiMa');
			Route::post('/createART','artInvController@createART');
			// *agregar ruta para eliminar item
		});
		Route::group(['prefix' => '/venta'], function(){
			Route::get('/formulario','VentaController@index')->name('formularioVenta');
			Route::post('/agregar','VentaController@agregarAlCarrito')->name('venta-agregar');
			Route::get('/eliminar/{id}','VentaController@eliminarDelCarrito')->name('venta-eliminar');
			Route::get('/reiniciar','VentaController@resetCarrito')->name('reiniciar-carrito');
			Route::get('/factura','VentaController@genFactura')->name('generar-factura');
			Route::get('/printFactura','VentaController@printFactura')->name('imprimir-factura');
			Route::post('/cerrarVenta','VentaController@cerrarVenta')->name('cerrarVenta');
			Route::get('/regisVenta','VentaController@indexRegisVenta')->name('registro-ventas');
//--------Rutas  para el nuevo modelo de venta V2
            Route::get('/formularioV2','VentaController@indexV2')->name('formularioVentaV2');
            Route::get('/datoArtVenta/{id}','VentaController@datoVentaArt');
            Route::get('/buscarCliente/{id}','VentaController@buscarCliente');
            Route::post('/agregarV2','VentaController@agregarAlCarritoV2');
            Route::get('/listaVentaV2','VentaController@carritoVentaLista');
            Route::get('/eliminar/{id}','VentaController@eliminarDelCarritoV2');
            Route::get('/ventaVerificar','VentaController@verificarventa');
            Route::get('/ventaVerificarStock','VentaController@verificarventaStockArt');
            Route::get('/registrarVenta/{nit}/pago/{pago}','VentaController@registrarVenta');
            Route::post('/anularFactura','VentaController@anularVenta');


        });
		Route::group(['prefix' => '/clientes'], function(){
			Route::get('/home','ClientesController@index')->name('clientes-home');
			Route::post('/create','ClientesController@create')->name('clientes-registrar');
			Route::get('/buscarCliente/{nit}','ClientesController@show');
			Route::get('/verificarExistenciaCliente/{nit}','ClientesController@showVerificar');
			Route::get('clienteEdit','ClientesController@edit');
			Route::post('updateCliente','ClientesController@update');
			Route::post('delete','ClientesController@delete');

		});
		Route::group(['prefix' => '/reportes'], function(){
			Route::get('/home','reportesController@index')->name('home-reportes');
			Route::get('/artculos','reportesController@impArtReports')->name('impArtReport-reportes');
			Route::get('/ReportesVentas','reportesController@indexReportVentas')->name('ReportVentas-reportes');
			Route::post('/generarReporteVenta','reportesController@generarReporteventas')->name('generar-reporte-ventas');
			Route::get('reportePrueba','reportesController@reportePrueba');
		});

});

