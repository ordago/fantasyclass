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

        // Groups
        Route::get('/{code}/groups', 'GroupsController@index'); // Policy protect
        Route::post('/{code}/groups/create', 'GroupsController@store'); // Policy protect
        Route::patch('/{code}/groups', 'GroupsController@update'); // Policy protect

        // Students
        Route::get('/{code}/students/add', 'StudentController@create'); // Policy protect
        Route::post('/students/', 'StudentController@store'); // Policy protect (?)
        Route::post('/students/getusername', 'StudentController@getUsername');
        Route::post('/students/update', 'StudentController@update'); // Policty protect
        Route::get('/{code}/student/{id}', 'StudentController@show'); // Policy protect

        Route::post('/{code}/student/changecharacter', 'StudentController@changeCharacter'); // Policy protect
        Route::post('/students/behaviour', 'StudentController@addBehaviour'); // Policty protect
        Route::patch('/{code}/student/inventory', 'InventoryController@update'); // Policty protect

        // Student View
        Route::get('/show/{code}', 'ClassroomsStudentController@show'); // Policy protect
        Route::post('/{code}/student/useitem', 'ClassroomsStudentController@useItem'); // Policy protect
        Route::post('/{code}/student/buyitem', 'ClassroomsStudentController@buyItem'); // Policy protect
        Route::post('/{code}/student/buyequipment', 'ClassroomsStudentController@buyEquipment'); // Policy protect
        
        // Behaviours
        Route::get('/{code}/behaviours', 'BehaviourController@index'); // Policy protect
        Route::get('/{code}/behaviours/create', 'BehaviourController@create'); // Policy protect
        Route::post('/{code}/behaviours', 'BehaviourController@store'); // Policy protect
        Route::delete('/behaviour/{id}', 'BehaviourController@destroy'); // Policy protect
        Route::get('/{code}/behaviours/{id}', 'BehaviourController@show'); // Policy protect
        Route::patch('/{code}/behaviours/{id}', 'BehaviourController@update'); // Policy protect
        
        // Levels
        Route::get('/{code}/levels', 'LevelsController@index'); // Policy protect
        Route::post('/{code}/levels', 'LevelsController@store'); // Policy protect
        Route::patch('/{code}/levels/{level}', 'LevelsController@update'); // Policy protect
        Route::delete('/level/{id}', 'LevelsController@destroy'); // Policy protect

        // Challenges
        Route::get('/{code}/challenges', 'ChallengesGroupController@index'); // Policy protect
        Route::post('/{code}/challenges/group', 'ChallengesGroupController@store'); // Policy protect
        Route::post('/{code}/challenges', 'ChallengesController@store'); // Policy protect
        Route::post('/{code}/challenges/get', 'ChallengesController@index'); // Policy protect
        Route::post('/challenges/image', 'ChallengesController@uploadImage'); // Policy protect
        Route::delete('/{code}/challenges/{id}', 'ChallengesController@destroy'); // Policy protect
        Route::patch('/{code}/challenges/{id}', 'ChallengesController@update'); // Policy protect
        
        // Shop
        Route::get('/{code}/shop', 'ShopController@index'); // Policy protect
        Route::get('/{code}/shop/create', 'ShopController@create'); // Policy protect
        Route::post('/{code}/shop', 'ShopController@store'); // Policy protect
        Route::patch('/{code}/shop', 'ShopController@update'); // Policy protect
        Route::patch('/{code}/shop/forsale', 'ShopController@updateForSale'); // Policy protect
        Route::delete('/{code}/shop/{id}', 'ShopController@destroy'); // Policy protect
        Route::get('/{code}/shop/{id}', 'ShopController@show'); // Policy protect
        
        // Settings
        Route::patch('/{code}/setting', 'ClassroomsController@updateSetting'); // Policy protect
        Route::post('/{code}/setting/updateavatar', 'ClassroomsStudentController@updateavatar'); // Policy protect

        // Maps
        Route::get('/{code}/maps', 'MapsController@index'); // Policy protect
        Route::get('/{code}/maps/{id}', 'MapsController@show'); // Policy protect
        Route::get('/{code}/maps/create', 'MapsController@create'); // Policy protect
        
    });
    
    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');
});
