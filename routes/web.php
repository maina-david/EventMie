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
    if(!file_exists(storage_path()."/installed")) {
        header('location:license');die;
    }

    return view('welcome');
});

Route::get('/license', 'App\Http\Controllers\LicenseController@index');
Route::get('/52cab7070ba5124895a63a3703f66893232', function() {
    header('location:install');die;
});

if(file_exists(storage_path()."/installed")) {
    Eventmie::routes();
}