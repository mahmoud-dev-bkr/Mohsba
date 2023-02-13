<?php
//commit
use App\DataTables\SalaryDataTable;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
// 'middleware' => 'auth',
// Route::get('/test', [SalaryDataTable::class, 'query']);

Route::group(['prefix' => 'dashboard',  'namespace' => 'Dashboard'], function () {

    Route::get('/client',               [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/create',        [ClientController::class, 'create'])->name('client.create');
    Route::get('/client/update/{id}',        [ClientController::class, 'edit'])->name('client.update');
    Route::post('/client/edit/{id}',        [ClientController::class, 'update'])->name('client.edit');
    Route::post('/client/create/post',  [ClientController::class, 'store'])->name('client.create.post');
    Route::get('/client/data',          [ClientController::class, 'getClients'])->name('getClientsData');
    Route::post('/client/destroy/{id}',   [ClientController::class, 'destroy'])->name('client.destroy');



    // Route::group(['prefix'=>'ajax_Quotations'],function(){
    //     Route::get('quotation','QuotationsController@show');
    //     Route::post('create','QuotationsController@store')->name('ajax.create');
    //     Route::get('edit/{Quotations_id}','QuotationsController@store')->name('ajax.create');
    //     Route::post('delete','QuotationsController@delete')->name('ajax.delete');
    //     Route::post('update','QuotationsController@update')->name('ajax.update');
    //     Route::get('select','QuotationsController@select')->name('ajax.Client.select');
    // });


    // Route::group(['prefix'=>'ajax_SI'],function(){
    //     Route::get('sales_invoices','sales_invoicesController@show');
    //     Route::post('create','sales_invoicesController@store')->name('ajax.sales_invoices.create');
    //     Route::get('edit/{sales_invoices_id}','sales_invoicesController@store')->name('ajax.sales_invoices.create');
    //     Route::post('delete','sales_invoicesController@delete')->name('ajax.sales_invoices.delete');
    //     Route::post('update','sales_invoicesController@update')->name('ajax.sales_invoices.update');
    //     Route::get('select','sales_invoicesController@select')->name('ajax.select.Client');
    // });



});

Route::group(['prefix' => '/'], function () {
  Route::get('{first}/{second}/{third}', 'RoutingController@thirdLevel')->name('third');
  Route::get('{first}/{second}', 'RoutingController@secondLevel')->name('second');
  Route::get('{any}', 'RoutingController@root')->name('any');
});

// landing
Route::get('', 'RoutingController@index')->name('index');

