<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.dashboard');
})->middleware('auth');

Route::get('/ticket', function () {
    return view('ticket');
});

Auth::routes();

Route::get('/main', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::apiResource('/roles',\App\Http\Controllers\Mantenimientos\RoleController::class);
Route::get('/roles-all',[\App\Http\Controllers\Mantenimientos\RoleController::class,'getRoles']);
Route::apiResource('/users',\App\Http\Controllers\Mantenimientos\UserController::class);
Route::apiResource('/modulos',\App\Http\Controllers\Mantenimientos\ModuloImpresionController::class);
Route::get('/modulos-all',[\App\Http\Controllers\Mantenimientos\ModuloImpresionController::class,'getModulos']);
Route::apiResource('/desks',\App\Http\Controllers\Mantenimientos\DeskController::class);
Route::get('/desks-all',[\App\Http\Controllers\Mantenimientos\DeskController::class,'getDesks']);
Route::apiResource('/tickets',\App\Http\Controllers\Mantenimientos\TicketController::class);
Route::apiResource('/ticketeras',\App\Http\Controllers\Mantenimientos\TicketerasController::class);
Route::apiResource('/query_type_customers',\App\Http\Controllers\Mantenimientos\QueryTypeCustomerController::class);
Route::get('/query_type_customers_all',[\App\Http\Controllers\Mantenimientos\QueryTypeCustomerController::class,'getQueryTypeCustomers']);
Route::apiResource('/carousels',\App\Http\Controllers\Mantenimientos\CarouselController::class);
Route::get("/carousels/load/{id}",[\App\Http\Controllers\Mantenimientos\CarouselController::class,'getFileContent']);

//reportes - listas

Route::get('/report-queue-list',[\App\Http\Controllers\Reportes\QueueListReportController::class,'getQueueList']);


//dashboard

Route::get('/admin1',[\App\Http\Controllers\Dashboard\DashboardAdminController::class,'getDataGeneral'])->name('dashboard.admin1');



Route::get('/buscar-persona/{nro}',[\App\Http\Controllers\Search\SearchOracleController::class,'findPersonaNroDNIOrCIP'])->name('buscar.persona');
Route::put('/llamar-cliente/{id}',[\App\Http\Controllers\Api\ProcesaController::class,'procesaCall'])->name('procesa.llamada');
Route::put('/start-cliente/{id}',[\App\Http\Controllers\Api\ProcesaController::class,'procesaStart'])->name('procesa.start');
Route::put('/cliente-ausente-cliente/{id}',[\App\Http\Controllers\Api\ProcesaController::class,'procesaClienteAusente'])->name('procesa.ausente');
Route::put('/procesa-atencion-all/{id}',[\App\Http\Controllers\Api\ProcesaController::class,'procesaAtencionAll'])->name('procesa.all');


Route::get('/informacion-user/{user_id}',[\App\Http\Controllers\Api\getResourceController::class,'getInfomacionUser']);
Route::get('/lista-tickets-por-atender/{user_id}',[\App\Http\Controllers\Api\getResourceController::class,'getTicketsPorAtender']);
Route::get('/lista-mis-atenciones/{user_id}',[\App\Http\Controllers\Api\getResourceController::class,'misAtenciones']);
Route::get('/find-queue-list/{id}',[\App\Http\Controllers\Api\getResourceController::class,'getOneFullRelationQueueList']);
Route::get('/desk-all',[\App\Http\Controllers\Api\getResourceController::class,'getAlllDesks']);


Route::view('/view-offices','configuraciones.oficinas')->name('view.oficinas');
Route::view('/view-modulo','configuraciones.modulo-impresion')->name('view.modulo');
Route::view('/view-posiciones','configuraciones.posiciones')->name('view.posiciones');
Route::view('/view-ticketeras','configuraciones.tickets')->name('view.tickets');
Route::view('/view-videos','configuraciones.videos')->name('view.videos');
Route::view('/query-type-customer','configuraciones.query-type-customer')->name('view.query-type-customer');
Route::view('/vew-report','reportes.queue-list-report')->name('view.report-queuelist');


Route::view('/ventana','atencion.ventana')->name('view.ventana');
Route::view('/atenciones','atencion.atencion') ->name('view.atenciones')->middleware('auth');
Route::view('/view-roles','accesos.role')->name('view.role')->middleware('auth');
Route::view('/view-users','accesos.user')->name('view.user')->middleware('auth');
Route::view('/settings','configuraciones.configuraciones')->name('settings.setting')->middleware('auth');


