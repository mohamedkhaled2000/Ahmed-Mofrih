<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});


Auth::routes();
//Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('invoices', 'InvoicesController');
Route::resource('sections', 'SectionsController');
Route::resource('products', 'ProductsController');
Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');
Route::resource('InvoiceAchive', 'InvoiceAchiveController');
Route::resource('Archive', 'InvoiceAchiveController');



///////
Route::get('/section/{id}', 'InvoicesController@getproducts');
Route::get('export_invoices', 'InvoicesController@export');




Route::get('report_invoices', 'Invoices_Report@report');
Route::get('customers_report', 'Invoices_Report@customers_report');

Route::post('Search_invoices', 'Invoices_Report@Search_invoices');
Route::post('Search_customers', 'Invoices_Report@Search_customers');


Route::get('MarkAsRead_all', 'MarkAsRead@MarkAsRead')->name('MarkAsRead_all');



Route::get('invoices_paid', 'InvoicesController@paid')->name('invoices_paid');
Route::get('invoices_Partial', 'InvoicesController@partial')->name('invoices_Partial');
Route::get('invoices_UnPaid', 'InvoicesController@unpaid')->name('invoices_UnPaid');
Route::get('Archive_invoices', 'InvoiceAchiveController@index')->name('Archive_invoices');

Route::get('/InvoicesDetails/{id}', 'InvoicesDetailsController@edit');
Route::get('/Print_invoice/{id}', 'InvoicesController@print');
Route::get('/Status_show/{id}', 'InvoicesController@Status')->name('Status_show');

Route::get('/edit_invoices/{id}', 'InvoicesController@edit');
Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');
Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');
Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');
Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
  
    });

Route::get('/{page}', 'AdminController@index');
  

