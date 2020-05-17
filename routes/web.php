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
    Route::redirect('/', '/classroom');
    
    // Classroom
    Route::get('/classroom', 'ClassroomsController@index')->name('classrooms');
    Route::post('/classroom', 'ClassroomsController@store'); //Policy protect
    Route::get('/classroom/create', 'ClassroomsController@create');
    Route::get('/classroom/{code}', 'ClassroomsController@show'); // Policy protect
    
    // Cards
    Route::delete('/classroom/card/{id}', 'CardsController@destroy'); // Policy protect
    Route::get('/classroom/{code}/cards', 'CardsController@index'); // Policy protect
    Route::get('/classroom/{code}/cards/import/default', 'CardsController@importDefault'); // Policy protect
    Route::get('/classroom/{code}/cards/create', 'CardsController@create'); // Policy protect

    // Students
    Route::get('/classroom/{code}/students/add', 'StudentController@create'); // Policy protect
    Route::post('/classroom/students/', 'StudentController@store'); // Policy protect (?)
    Route::post('/classroom/students/getusername', 'StudentController@getUsername');
    Route::post('/classroom/students/update', 'StudentController@update'); // Policty protect

    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');

    
});