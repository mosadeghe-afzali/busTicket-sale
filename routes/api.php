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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/users'], function (){
    Route::post('/store', 'AuthController@store')->name('users.store');
    Route::post('/login', 'AuthController@login')->name('login');
});

Route::group(['prefix' => '/vehicles', 'middleware' => ['auth:api', 'permissions:admin,super_user,company']], function (){
    Route::post('/store', 'VehicleController@store')->name('vehicles.store');
    Route::put('/update/{id}', 'VehicleController@update')->name('vehicle.update');
    Route::delete('/delete/{id}', 'VehicleController@destroy');
    Route::get('/', 'VehicleController@index');
});

Route::group(['prefix' => 'schedules', 'middleware' => ['auth:api', 'permissions:admin,super_user,company']], function(){
    Route::post('/store', 'ScheduleController@store');
    Route::put('/update/{id}', 'ScheduleController@update');
    Route::post('/list', 'ScheduleController@list')->withoutMiddleware(['auth:api', 'permissions:admin,super_user,company']);
});

Route::group(['prefix' => '/companies'], function() {
    Route::get('/', 'CompanyController@list');
    Route::get('/comments', 'CompanyController@getComments');
    Route::get('/info', 'CompanyController@info');
});

Route::group(['prefix' => '/reservation', 'middleware' => 'auth:api'], function() {
    Route::get('/show/{id}', 'ReservationController@availableSeats')->withoutMiddleware('auth:api');
    Route::post('/{id}', 'ReservationController@doReserve')->middleware('auth:api');
    Route::get('/ticket/{id}', 'ReservationController@ticket')->middleware('auth:api');
    Route::get('/pdfTicket/{id}', 'ReservationController@getPdfTicket');
});

Route::group(['prefix' => '/pay', 'middleware' => 'auth:api'], function() {
    Route::post('/{id}', 'PaymentController@payRequest');
    Route::get('/result/{id}', 'PaymentController@pay');
});
