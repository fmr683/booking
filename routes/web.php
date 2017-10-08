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


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('booking-type', 'BookingTypeController');
Route::resource('price-mapping', 'PriceMappingController');
Route::get('price-mapping/by-day-type/{id}', 'PriceMappingController@byDayType');

Route::resource('addon', 'AddonController');
Route::get('addon/by-day-type/{id}', 'AddonController@byDayType');

Route::resource('booking', 'BookingController');
Route::patch('booking/deactive/{id}', 'BookingController@deactiveBooking');
Route::get('booking/check-duplicate/{day_type}/{pm_id}/{b_date}', 'BookingController@checkDuplicateBookings');


Route::resource('user', 'UserController');

