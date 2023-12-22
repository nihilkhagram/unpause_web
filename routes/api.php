<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register', 'API\ApiController@register');
Route::post('bleaddress/add', 'API\ApiController@ble_address');
Route::post('bleaddress/delete', 'API\ApiController@ble_address_delete');
Route::post('register_new', 'API\ApiController@register');
Route::post('login', 'API\ApiController@login');
Route::post('request_otp', 'API\ApiController@request_otp');
Route::post('verify_otp', 'API\ApiController@verify_otp');
Route::post('send_otp_for_forgot_password', 'API\ApiController@send_otp_for_forgot_password');
Route::post('verify_otp_for_forgot_password', 'API\ApiController@verify_otp_for_forgot_password');
Route::post('reset_password', 'API\ApiController@reset_password');
Route::get('ota_file', 'API\ApiController@ota_file');



/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});*/
Route::middleware('auth:api')->group( function () {
	Route::post('cat', 'API\ApiController@cat');
    Route::post('test', 'API\ApiController@test');
    Route::post('testnew', 'API\ApiController@testnew');
    Route::post('alert/hours', 'API\ApiController@alerthours');
    Route::post('testadd', 'API\ApiController@testadd');
    Route::post('add_report', 'API\ApiController@add_report');
    Route::post('add_symptom', 'API\ApiController@add_symptom');
   // Route::post('update_symptom', 'API\ApiController@update_symptom');
    Route::post('listing_symptom', 'API\ApiController@listing_symptom');
    Route::post('generate_pdf_menopause', 'API\ApiController@generate_pdf_menopause');
    Route::post('get_appointment', 'API\ApiController@get_appointment');
    Route::post('change_symptom', 'API\ApiController@change_symptom');
    Route::post('add_user_symptom', 'API\ApiController@add_user_symptom');
    Route::post('update_user_symptom', 'API\ApiController@update_user_symptom');
    Route::post('update_user_name', 'API\ApiController@update_user_name');
    Route::post('get_feedback', 'API\ApiController@get_feedback');

    Route::post('delete_user', 'API\ApiController@delete_user');


    Route::post('fetch_user_symptom', 'API\ApiController@fetch_user_symptom');
    Route::post('get_appointment_notification', 'API\ApiController@get_appointment_notification');

    Route::post('fetch_symptom_progress_count', 'API\ApiController@fetch_symptom_progress_count');


    Route::post('get_appointment_information', 'API\ApiController@get_appointment_information');



    Route::post('post', 'API\ApiController@post');
    Route::post('product_list', 'API\ShopApiController@product_list');
    Route::post('product_detail', 'API\ShopApiController@product_detail');
    Route::post('product_detail_by_color', 'API\ShopApiController@product_detail');
    Route::post('add_cart', 'API\ShopApiController@add_cart');
    Route::post('remove_cart', 'API\ShopApiController@remove_cart');
    Route::post('cart_list', 'API\ShopApiController@cart_list');
    Route::post('add_shipping_address', 'API\ShopApiController@add_shipping_address');
    Route::post('edit_shipping_address', 'API\ShopApiController@edit_shipping_address');
    Route::post('shipping_address_list', 'API\ShopApiController@shipping_address_list');
    Route::post('apply_promocode', 'API\ShopApiController@apply_promocode');
    Route::post('add_order', 'API\ShopApiController@add_order');
    Route::post('order_list', 'API\ShopApiController@order_list');
    Route::post('add_review', 'API\ShopApiController@add_review');
    Route::post('cart_detail', 'API\ShopApiController@cart_detail');
    Route::post('cart_product_detail', 'API\ShopApiController@cart_product_detail');
    Route::post('add_cart_address', 'API\ShopApiController@add_cart_address');
    Route::post('stripe_payment', 'API\ShopApiController@stripe_payment');
    Route::post('send_email', 'API\ShopApiController@send_email');
    Route::post('cart_count', 'API\ShopApiController@cart_count');
    Route::post('dashboard', 'API\ShopApiController@dashboard');
    Route::post('primary_address', 'API\ShopApiController@primary_address');
    Route::post('add_refund_request', 'API\ShopApiController@add_refund_request');
    Route::post('order_again', 'API\ShopApiController@order_again');


});




