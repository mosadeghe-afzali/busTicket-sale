<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
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
    Route::post('/store', [AuthController::class, 'store'])->name('users.store');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
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
});

Route::get('/companies', 'CompanyController@list');
Route::get('/comments', 'CompanyController@getComments');
Route::post('/list', 'ScheduleController@list');
Route::get('/info', 'CompanyController@info');

Route::get('/reserve/{id}', 'ReservationController@availableSeats');

Route::post('/reservation/{id}', 'ReservationController@doReserve' )->middleware('auth:api');
