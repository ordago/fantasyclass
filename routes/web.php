<?php

use App\Http\Middleware\Localization;
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

Route::group(['middleware' => 'language'], function () {

    Auth::routes(['verify' => true]);
    
    // Home
    Route::redirect('/', '/classrooms');
    
    // Classroom
    Route::get('/classrooms', 'ClassroomsController@index');
    Route::post('/classrooms', 'ClassroomsController@store');
    Route::get('/classrooms/create', 'ClassroomsController@create');
    
});


