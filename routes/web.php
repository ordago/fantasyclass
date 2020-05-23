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
    Route::prefix('classroom')->group(function () {
        Route::get('/', 'ClassroomsController@index')->name('classrooms');
        Route::post('/', 'ClassroomsController@store'); //Policy protect
        
        Route::get('create', 'ClassroomsController@create');
        Route::get('{code}', 'ClassroomsController@show'); // Policy protect

        // Cards
        Route::delete('/card/{id}', 'CardsController@destroy'); // Policy protect
        Route::get('/{code}/cards', 'CardsController@index'); // Policy protect
        Route::get('/{code}/cards/import/default', 'CardsController@importDefault'); // Policy protect
        Route::get('/{code}/cards/create', 'CardsController@create'); // Policy protect
        Route::post('/{code}/cards', 'CardsController@store'); // Policy protect
        Route::get('/{code}/cards/{card}', 'CardsController@show'); // Policy protect
        Route::patch('/{code}/cards/{card}', 'CardsController@update'); // Policy protect
        
        // Students
        Route::get('/{code}/students/add', 'StudentController@create'); // Policy protect
        Route::post('/students/', 'StudentController@store'); // Policy protect (?)
        Route::post('/students/getusername', 'StudentController@getUsername');
        Route::post('/students/update', 'StudentController@update'); // Policty protect
        
        Route::post('/students/behaviour', 'StudentController@addBehaviour'); // Policty protect
        
        // Behaviours
        Route::get('/{code}/behaviours', 'BehaviourController@index'); // Policy protect
        Route::get('/{code}/behaviours/create', 'BehaviourController@create'); // Policy protect
        Route::post('/{code}/behaviours', 'BehaviourController@store'); // Policy protect
        Route::delete('/behaviour/{id}', 'BehaviourController@destroy'); // Policy protect
        Route::get('/{code}/behaviours/{id}', 'BehaviourController@show'); // Policy protect
        Route::patch('/{code}/behaviours/{id}', 'BehaviourController@update'); // Policy protect
        
    });
        
    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');

});