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

/*Route::get('/', function () {
    return view('welcome');
});*/
Auth::routes();
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('test_pdf','API\ApiController@test_pdf');
Route::get('report_pdf','API\ApiController@report_pdf');

Route::group(['middleware' => ['auth']], function()
{
	Route::get('otas','HomeController@otas');
	Route::post('otas','HomeController@otas_post');

	Route::get('/', function () {
	    return view('dashboard');
	});

	//all product list
	Route::get('/product_management','ProductManagerController@index');
	
	//site setting
	
	Route::resource('site_setting', 'SitesettingController');
	Route::resource('pdf_template', 'TemplateController');
	Route::post('template_filter','TemplateController@template_filter');
	
	
		
		Route::get('/profile', 'AdminController@view_profile')->name('admin.profile');
		Route::get('/change/password', 'AdminController@change_password')->name('admin.change_password');
		Route::post('/profile', 'AdminController@update_profile')->name('admin.profile.update');
		
	
		//
		Route::post('users_filter','UsersController@users_filter');
		Route::get('/users/{id}/edit','UsersController@edit');
		Route::resource('users', 'UsersController');

				//
				Route::post('menopause_filter','MenopauseController@menopause_filter');
				Route::get('/menopause/{id}/edit','MenopauseController@edit');
				Route::resource('menopause', 'MenopauseController');
				Route::get('/menopause/{id}/view', 'MenopauseController@generate_pdf');
		
	

	//test table
	Route::post('test_filter', 'TestController@test_filter');
	Route::get('/test/{id}/edit', 'TestController@edit');
	Route::resource('test', 'TestController');

	//test table
	Route::post('symptom_filter', 'SymptomController@symptom_filter');
	Route::get('/symptom/{id}/edit', 'SymptomController@edit');
	Route::resource('symptom', 'SymptomController');

	// //test table
	// Route::post('report_filter', 'ReportController@report_filter');
	// Route::get('/report/{id}/edit', 'ReportController@edit');
	// Route::resource('report', 'ReportController');
	
	//test table
	Route::post('reports_filter', 'ReportController@reports_filter');
	Route::get('/reports/{id}/edit', 'ReportController@edit');
	Route::resource('reports', 'ReportController');
	Route::resource('orders', 'OrderController');	
	Route::post('order_filter', 'OrderController@order_filter');
	Route::get('/order/pdf/{id}', 'OrderController@pdf');
	Route::post('order_status', 'OrderController@order_status')->name('order_status');


		//common table request
		Route::post('statuschange', 'AdminController@statuschange')->name('admin.statuschange');
		Route::post('tableaction',  'AdminController@tableaction')->name('admin.tableaction');	

		Route::resource('roleModule', 'RoleModuleController');
		Route::post('rolemodule_filter','RoleModuleController@rolemodule_filter');
		Route::resource('rolePermission', 'RolePermissionController');	
		
		Route::post('rolepermission_filter','RolePermissionController@rolepermission_filter');

		Route::get('/', 'DashboardManagerController@index');

		//notification
	Route::view('notification', 'notification.notification')->name('notification.form');
	Route::post('/notification/send', 'UsersController@sendNotification')->name('notification.send');


		
});
Route::get('send-mail', function () {
   
    $mail_details = [
        'subject' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('chandaniramani7@gmail.com')->send(new \App\Mail\sendEmail($mail_details));
   
    dd("Email is Sent.");
});

Route::get('/order_email', function () {
   
    return view('order_pdf');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/send_notification', 'UsersController@send_notification')->name('send_notification');
