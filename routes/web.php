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
use App\Http\Middleware\AllowedUsers;

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('booking-type', 'BookingTypeController')->middleware(AllowedUsers::class);
Route::resource('price-mapping', 'PriceMappingController')->middleware(AllowedUsers::class);
Route::get('price-mapping/by-day-type/{id}', 'PriceMappingController@byDayType')->middleware(AllowedUsers::class);

Route::resource('addon', 'AddonController')->middleware(AllowedUsers::class);
Route::get('addon/by-day-type/{id}', 'AddonController@byDayType')->middleware(AllowedUsers::class);

Route::resource('booking', 'BookingController')->middleware(AllowedUsers::class);
Route::patch('booking/deactive/{id}', 'BookingController@deactiveBooking')->middleware(AllowedUsers::class);
Route::get('booking/check-duplicate/{day_type}/{pm_id}/{b_date}/{bid}', 'BookingController@checkDuplicateBookings')->middleware(AllowedUsers::class);


Route::resource('user', 'UserController')->middleware(AllowedUsers::class);

