<?php

use App\Http\Controllers\AuthController;
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
    return view('home');
})->name('home');


Route::group(['prefix' => '/users'], function(){

    Route::get('/register', function(){
        return view('users.register');
    })->name('users.create');

    Route::get('/loginPage', function(){
        return view('users.login');
    })->name('loginPage');
});
Route::get('/addVehicle', function(){
    return view('panel.addVehicle');
})->name('addVehicle');
