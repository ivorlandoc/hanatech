<?php
include_once 'web_builder.php';
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

Route::pattern('slug', '[a-z0-9- _]+');

Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {

    # Error pages should be shown without requiring login
    Route::get('404', function () {return view('admin/404'); });
    Route::get('500', function () {return view('admin/500'); });
    # Lock screen
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('lockscreen');
    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    Route::get('login2', function () {return view('admin/login2'); });


    # Register2
    Route::get('register2', function () {return view('admin/register2');});
    Route::post('register2', 'AuthController@postRegister2')->name('register2');

    # Forgot Password Confirmation
    Route::get('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm')->name('forgot-password-confirm');
    Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm');

    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');

    # Account Activation
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    # GUI Crud Generator
    Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('generator_builder');

    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
    // Model checking
    Route::post('modelCheck', 'ModelcheckController@modelCheck');

    # Dashboard / Index
    Route::get('/', 'JoshController@showHome')->name('dashboard');
    # crop demo
    Route::post('crop_demo', 'JoshController@crop_demo')->name('crop_demo');
    
    //Log viewer routes
    Route::get('log_viewers', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index')->name('log-viewers');
    Route::get('log_viewers/logs', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs')->name('log_viewers.logs');
    Route::delete('log_viewers/logs/delete', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete')->name('log_viewers.logs.delete');
    Route::get('log_viewers/logs/{date}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show')->name('log_viewers.logs.show');
    Route::get('log_viewers/logs/{date}/download', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download')->name('log_viewers.logs.download');
    Route::get('log_viewers/logs/{date}/{level}', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel')->name('log_viewers.logs.filter');
    Route::get('log_viewers/logs/{date}/{level}/search', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@search')->name('log_viewers.logs.search');
    Route::get('log_viewers/logcheck', '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@logCheck')->name('log-viewers.logcheck');
    //end Log viewer
    # Activity log
    Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
//    Route::get('/', 'JoshController@index')->name('index');
});

Route::group(['prefix' => 'servicio', 'namespace'=>'Servicio','middleware' => 'admin'], function () {
    Route::get('reservas', 'ReservaPlazaController@index');
    Route::get('reservas/bandeja', 'ReservaPlazaController@getshow');      
});


Route::group(['prefix' => 'reportes', 'namespace'=>'Reporte','middleware' => 'admin'], function () {
    /*==================================rpte de plazas activas, inactivas y vacantes, etc=============================================*/
    Route::get('rplazas', 'RptegeneralplazasController@index');  
    Route::post( '/rplazas', array('as' => 'get-rpte-plaza','uses' => 'RptegeneralplazasController@getrpteplazas'));
    Route::get('rplazas/{id}', 'RptegeneralplazasController@getRpteExcel')->name("reportes.rplazas.index");
    /*==================================Plazas por cargo=============================================*/
    Route::get('plazacargo', 'PlazasporcargoController@index'); 
    Route::post( '/plazacargo', array('as' => 'get-plaza-cargo','uses' => 'PlazasporcargoController@getallplazascargo'));
    /*==================================reportes=============================================*/
    Route::get('reject', 'RptejectController@index'); 
    Route::post('reject', array('as' => 'get-plaza-ejec','uses' => 'RptejectController@showejec'));
    /*==================================Altas y bajas=============================================*/
    Route::get('rbajas', 'RptealtabajasController@index'); 
    Route::post('rbajas', array('as' => 'get-rpte-altabaja','uses' => 'RptealtabajasController@getallrptealtabajas'));
});

Route::resource('reportes', 'PlazasporcargoController'); // add by iv.orlando.c 22.02.18

Route::group(['prefix' => 'admin', 'namespace'=>'Admin','middleware' => 'admin'], function () {
    /*==================================reservas=============================================*/
    Route::get('reserva', 'ReservaController@index');
    Route::post('reserva', array('as' => 'get-datos-parareserva','uses' => 'ReservaController@GetDatosRserva'));
    Route::post('reserva/{id}', array('as' => 'get-datos-procesareserva','uses' => 'ReservaController@Procesareservaplaza'));
    Route::post('reserva/{id}/{idx}', array('as' => 'procesa-ChangeEstado','uses' => 'ReservaController@ProcesaChangeEstado'));
    /*==================================Crea plazas=============================================*/
     Route::get('creaplaza', 'CrearplazaController@index');  
    Route::post('creaplaza/{id}', array('as' => 'get-all-estruct','uses' => 'CrearplazaController@getStructuras'));
    Route::post('creaplaza/{id}/{idx}', array('as' => 'set-save-contador_plaza','uses' => 'CrearplazaController@Procesacreaplaza'));
     /*==================================Recategorización de  plazas=============================================*/
    Route::get('integra', 'IntegrarPlazaController@index'); 
    Route::post('integra', array('as' => 'get-datos-paraintegra','uses' => 'IntegrarPlazaController@getdatosintegra'));
    Route::post('integra/{id}', array('as' => 'save-paraintegra-plazas','uses' => 'IntegrarPlazaController@Procesaintegraplaza'));
    /*==========================================================================================*/
});

Route::resource('admin', 'CrearplazaController'); 


 Route::group(['prefix' => 'admin', 'namespace'=>'Admin','middleware' => 'admin'], function () {    
    route::get('mantestruct','ManteEstructurasController@index');      
    Route::post('mantestruct',array('as'=>'save-update-mantestruct','uses'=>'ManteEstructurasController@updateOficinaEstruct')); 
    route::get('mantestruct/{id}','ManteEstructurasController@create')->name("create");
    
});       
Route::resource('mantestruct','ManteEstructurasController');




Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'Admin.'], function () {
    # User Management
        Route::group([ 'prefix' => 'users'], function () {
        Route::get('data', 'UsersController@data')->name('users.data');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
//        Route::post('{user}/passwordreset', 'UsersController@passwordreset')->name('passwordreset');
        Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');

    });
    Route::resource('users', 'UsersController');

    Route::get('deleted_users',['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('deleted_users');

    # Group Management
    Route::group(['prefix' => 'groups'], function () {
        Route::get('{group}/delete', 'GroupsController@destroy')->name('groups.delete');
        Route::get('{group}/confirm-delete', 'GroupsController@getModalDelete')->name('groups.confirm-delete');
        Route::get('{group}/restore', 'GroupsController@getRestore')->name('groups.restore');
    });
    Route::resource('groups', 'GroupsController');

    /*=============================routes for blog===============*/    
   /*
    Route::group(['prefix' => 'blog'], function () {
        Route::get('{blog}/delete', 'BlogController@destroy')->name('blog.delete');
        Route::get('{blog}/confirm-delete', 'BlogController@getModalDelete')->name('blog.confirm-delete');
        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
        Route::post('{blog}/storecomment', 'BlogController@storeComment')->name('storeComment');
    });
    Route::resource('blog', 'BlogController');   */
    /*==================routes for blog category=========================*/    
   /*
    Route::group(['prefix' => 'blogcategory'], function () {
        Route::get('{blogCategory}/delete', 'BlogCategoryController@destroy')->name('blogcategory.delete');
        Route::get('{blogCategory}/confirm-delete', 'BlogCategoryController@getModalDelete')->name('blogcategory.confirm-delete');
        Route::get('{blogCategory}/restore', 'BlogCategoryController@getRestore')->name('blogcategory.restore');
    });
    Route::resource('blogcategory', 'BlogCategoryController');
    */
    /*================================Gestion de RRHH==========================================*/    
        Route::group(['prefix' => 'tipo'], function () {
                Route::get('admin/tipo', 'TipocargoController@index');            
        });
        Route::resource('tipo', 'TipocargoController'); 

        Route::group(['prefix' => 'nivel'], function () {
                Route::get('admin/nivel', 'NivelesController@index');
           
        });
        Route::resource('nivel', 'NivelesController'); 

        Route::group(['prefix' => 'cargo'], function () {
                Route::get('admin/cargo', 'CargosController@index');             
        });
        Route::resource('cargo', 'CargosController');         
    /*==========================================================================*/
        Route::group(['prefix' => 'estructura'], function () {           
                route::get('admin/estructura','EstructurasController@index');                  
        });
        Route::resource('estructura', 'EstructurasController');   


    /*==================================exportar a pdf las estructuras===========================*/
        Route::group(['prefix' =>'filespdf','namespace'=>'Admin','middleware' => 'admin'], function () {
            route::get('filespdf/{id}','PdfEstructuraController@index')->name("admin.filespdf.index"); 
        }); 
        Route::resource('filespdf','PdfEstructuraController'); 

        

        /*===================================================================*/
        Route::group(['prefix' => 'plazas'], function () {
                Route::get('admin/plazas','PlazasController@index'); 
                route::get('admin/plazas','PlazasController@create');
        });
        Route::resource('plazas', 'PlazasController');
    /*=================================Baja de plazas=========================================================*/
        Route::group(['prefix' => 'bajaplazas'], function () {
                Route::get('admin/bajaplazas/{id}', 'BajaPlazasController@index');           
                Route::post('IdSaveb', 'BajaPlazasController@IdSaveb');
        });        
        Route::resource('bajaplazas', 'BajaPlazasController'); 
        /*==========================================================================================*/
         Route::group(['prefix' => 'gesplazas'], function () {
                Route::get('admin/gesplazas/{id}', 'GestionarPlazasController@GeTHeadPlazaMov'); 
        });
        Route::resource('gesplazas', 'GestionarPlazasController');
        /*======================Consulta de plazas===================================*/
         Route::group(['prefix' => 'admin', 'namespace'=>'admin','middleware' => 'admin'], function () { 
            Route::get('rpteplazas/{id}', 'RptePlazaController@index'); 
            //Route::post('/rpteplazas',array('as'=>'getdatosvacante','uses'=>'RptePlazaController@GetEstadoDePlazasMov')); 
        });
        Route::resource('rpteplazas', 'RptePlazaController');


        /*========================================================*/ 
         Route::group(['prefix' => 'altaplaza'], function () {
                Route::get('admin/altaplaza/{id}', 'AltadeplazaController@index');   
                Route::get('admin/altaplaza/{id}', 'AltadeplazaController@create');   
        });
        Route::resource('altaplaza', 'AltadeplazaController');
        /* ==================temporal======================== */
            Route::group(['prefix' => 'rptetempo'], function () {
            Route::get('admin/rptetempo/{id}', 'RpteTempoController@index');                  
        });
        Route::resource('rptetempo', 'RpteTempoController');
        /*==============hasta aquí el tempo, elimnar luego*/

        //Route::get('pdf','PdfEstructuraController@getIndex');
        








    /*routes for file*/
    Route::group(['prefix' => 'file'], function () {
        Route::post('create', 'FileController@store')->name('store');
        Route::post('createmulti', 'FileController@postFilesCreate')->name('postFilesCreate');
        Route::delete('delete', 'FileController@delete')->name('delete');
    });

    Route::get('crop_demo', function () {
        return redirect('admin/imagecropping');
    });


    /* laravel example routes */
    #Charts
   /* Route::get('laravel_chart', 'ChartsController@index')->name('laravel_chart');
    Route::get('database_chart', 'ChartsController@databaseCharts')->name('database_chart');

    # datatables
    Route::get('datatables', 'DataTablesController@index')->name('index');
    Route::get('datatables/data', 'DataTablesController@data')->name('datatables.data');

    # SelectFilter
    Route::get('selectfilter', 'SelectFilterController@index')->name('selectfilter');
    Route::get('selectfilter/find', 'SelectFilterController@filter')->name('selectfilter.find');
    Route::post('selectfilter/store', 'SelectFilterController@store')->name('selectfilter.store');

    # editable datatables
    Route::get('editable_datatables', 'EditableDataTablesController@index')->name('index');
    Route::get('editable_datatables/data', 'EditableDataTablesController@data')->name('editable_datatables.data');
    Route::post('editable_datatables/create', 'EditableDataTablesController@store')->name('store');
    Route::post('editable_datatables/{id}/update', 'EditableDataTablesController@update')->name('update');
    Route::get('editable_datatables/{id}/delete', 'EditableDataTablesController@destroy')->name('editable_datatables.delete');

//    # custom datatables
    Route::get('custom_datatables', 'CustomDataTablesController@index')->name('index');
    Route::get('custom_datatables/sliderData', 'CustomDataTablesController@sliderData')->name('custom_datatables.sliderData');
    Route::get('custom_datatables/radioData', 'CustomDataTablesController@radioData')->name('custom_datatables.radioData');
    Route::get('custom_datatables/selectData', 'CustomDataTablesController@selectData')->name('custom_datatables.selectData');
    Route::get('custom_datatables/buttonData', 'CustomDataTablesController@buttonData')->name('custom_datatables.buttonData');
    Route::get('custom_datatables/totalData', 'CustomDataTablesController@totalData')->name('custom_datatables.totalData');

    //tasks section
    Route::post('task/create', 'TaskController@store')->name('store');
    Route::get('task/data', 'TaskController@data')->name('data');
    Route::post('task/{task}/edit', 'TaskController@update')->name('update');
    Route::post('task/{task}/delete', 'TaskController@delete')->name('delete');*/

});

# Remaining pages will be called from below controller method
# in real world scenario, you may be required to define all routes manually

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('{name?}', 'JoshController@showView');
});

#FrontEndController
Route::get('login', 'FrontEndController@getLogin')->name('login');
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::get('register', 'FrontEndController@getRegister')->name('register');
Route::post('register','FrontEndController@postRegister')->name('register');
Route::get('activate/{userId}/{activationCode}','FrontEndController@getActivate')->name('activate');
Route::get('forgot-password','FrontEndController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'FrontEndController@postForgotPassword');

# Forgot Password Confirmation
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
Route::get('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@getForgotPasswordConfirm')->name('forgot-password-confirm');
# My account display and update details
Route::group(['middleware' => 'user'], function () {
    Route::put('my-account', 'FrontEndController@update');
    Route::get('my-account', 'FrontEndController@myAccount')->name('my-account');
});
Route::get('logout', 'FrontEndController@getLogout')->name('logout');
# contact form
Route::post('contact', 'FrontEndController@postContact')->name('contact');

#frontend views
Route::get('/', ['as' => 'home', function () {
    return view('index');
}]);

 
      
/*
Route::get('blog','BlogController@index')->name('blog');
Route::get('blog/{slug}/tag', 'BlogController@getBlogTag');
Route::get('blogitem/{slug?}', 'BlogController@getBlog');
Route::post('blogitem/{blog}/comment', 'BlogController@storeComment');
*/

Route::get('{name?}', 'FrontEndController@showFrontEndView');
# End of frontend views9

Auth::routes();