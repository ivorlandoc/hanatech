<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


});

Route::group(['middleware' =>['api', 'cors'],'namespace'=>'Admin','prefix' => 'admin', 'as' => 'admin.'], function(){

		route::get('/estructura/{id}','EstructurasController@GetSelectSegundoNivel');
		route::get('/plazas/{id}','EstructurasController@GetSelectSegundoNivel');
		route::get('/plazas/list/{id}','PlazasController@show');
		route::get('/estructura/list/{id}','EstructurasController@showdata');
		route::get('/estructura/detpobla/{id}','EstructurasController@showDetails');
		route::get('/bajaplazas/{id}','BajaPlazasController@GeTHeadPlaza');
		route::get('/bajaplazas/list/{id}','BajaPlazasController@GeTtipoBaja');
		route::get('/gesplazas/{id}','GestionarPlazasController@GeTHeadPlazaMov');
		route::get('/gesplazas/list/{id}','GestionarPlazasController@GeTtipoMov');
		
		route::post('/gesplazas/insert','GestionarPlazasController@ProcesaInsert');
		route::post('/bajaplazas/ProcesaBajaInsert','BajaPlazasController@ProcesaBajaInsert');
		
		
		Route::get('/rpteplazas/list/{id}', 'RptePlazaController@GetHistoriaMov'); 
		//Route::get('/rpteplazas/det/{id}', 'RptePlazaController@GetDetalleGeneralPlaza'); 
		Route::get('/rpteplazas/getplaza/{id}', 'RptePlazaController@GetEstadoDePlazas'); 
		Route::get('/rpteplazas/detplaza/{id}', 'RptePlazaController@GetEstadoDePlazasMov'); 

		Route::get('/altaplaza/{id}', 'AltadeplazaController@getPlaza'); 
		Route::get('/tipodoc/getforalta/{id}', 'TipodocumentoController@getListaForAlta'); 
		Route::get('/profesion/getforalta/{id}', 'ProfesionesController@getListProfesionesForAlta'); 
		Route::get('/altaplaza/gettipomov/{id}', 'AltadeplazaController@getTipoMovForALta'); 		
		route::get('/altaplaza/getregimen/{id}','AltadeplazaController@getRegimenForAlta');
		route::get('/altaplaza/getestru/{id}','AltadeplazaController@getEstructura');
		route::get('/altaplaza/getshowest/{id}','AltadeplazaController@getEstructuraShowLink');
		route::post('/altaplaza/insert','AltadeplazaController@ProcesaInsertAlta');

		route::get('/altaplaza/listper/{id}','AltadeplazaController@getResultSearchPer');
		route::get('/altaplaza/listset/{id}','AltadeplazaController@getResultSearchPerSet');

		route::get('/mantestruct/{id}','ManteEstructurasController@GetSelect');	
		route::get('/mantestruct/getlist/{id}','ManteEstructurasController@getResultSelect');		
		route::get('/mantestruct/list/{id}','ManteEstructurasController@getresult_change');
		route::get('/mantestruct/list2/{id}','ManteEstructurasController@showDetails');
		route::get('/mantestruct/list3/{id}','ManteEstructurasController@showdetalleestructura');
		//route::post('/mantestruct/insert','ManteEstructurasController@addNewEstructura');
		//route::post('/mantestruct/update','ManteEstructurasController@_cambiarDeEstructurapersona');

		route::get('/rptetempo/list/{id}','RpteTempoController@GetResultDet'); // temporal para  eliminar

		//route::get('/mantestruct/pdf/{id}','PdfEstructuraController@getGenerar'); 
		
});

Route::group(['middleware' =>['api', 'cors'],'namespace'=>'Servicio','prefix' => 'servicio', 'as' => 'servicio.'], function(){				
		route::post('/reservas/insert','ReservaPlazaController@ProcesaInsertSolicitudReserva');	
		route::get('/reservas/{id}','ReservaPlazaController@GetDetalleReserva');

		route::post('/reservas/insertAt','ReservaPlazaController@AtenderSolicitudServ');			
		route::get('/reservas/list/{id}','ReservaPlazaController@GetShowObservacion');
		
});


Route::group(['middleware' =>['api', 'cors'],'namespace'=>'reporte','prefix' => 'reportes', 'as' => 'reportes.'], function(){
		route::get('/rplazas/{id}','RpteGeneralPlazasController@getRptePlazas');
		//route::get('/rplazas/excel/{id}','RpteGeneralPlazasController@getRpteExcel');

		
});