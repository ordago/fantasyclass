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
        Route::post('/', 'ClassroomsController@store');
        Route::patch('/{code}', 'ClassroomsController@update');
        Route::get('create', 'ClassroomsController@create');
        Route::get('/{code}/edit', 'ClassroomsController@edit');
        Route::get('join/{code}', 'ClassroomsController@join');
        Route::get('{code}', 'ClassroomsController@show');

        // Cards
        Route::delete('/card/{id}', 'CardsController@destroy');
        Route::get('/{code}/cards', 'CardsController@index');
        Route::get('/{code}/card/random', 'CardsController@random');
        Route::post('/{code}/card/assign', 'CardsController@assign');
        Route::get('/{code}/cards/import/default', 'CardsController@importDefault');
        Route::get('/{code}/cards/create', 'CardsController@create');
        Route::post('/{code}/cards', 'CardsController@store');
        Route::get('/{code}/cards/{id}', 'CardsController@show');
        Route::patch('/cards/{id}', 'CardsController@update');
        Route::post('/card/usedelete/{id}', 'CardsController@useDelete');
        
        // Groups
        Route::get('/{code}/groups', 'GroupsController@index');
        Route::post('/{code}/groups/create', 'GroupsController@store');
        Route::patch('/{code}/groups/{action}', 'GroupsController@update');
        Route::delete('/groups/{id}', 'GroupsController@destroy');
        
        // Students
        Route::get('/{code}/students/add', 'StudentController@create');
        Route::post('/students/', 'StudentController@store');
        Route::post('/students/getusername', 'StudentController@getUsername');
        Route::post('/students/update', 'StudentController@update');
        Route::get('/{code}/student/{id}', 'StudentController@show');
        Route::post('/{code}/student/changecharacter', 'StudentController@changeCharacter');
        Route::post('/student/behaviour', 'StudentController@addBehaviour');
        Route::patch('/student/inventory', 'InventoryController@update');
        
        // Student View
        Route::get('/show/{code}', 'ClassroomsStudentController@show'); // Policy protect
        Route::get('/show/{code}/users', 'ClassroomsStudentController@index'); // Policy protect
        Route::get('/show/{code}/stories', 'ClassroomsStudentController@stories'); // Policy protect
        Route::post('/{code}/student/useitem', 'ClassroomsStudentController@useItem'); // Policy protect
        Route::post('/{code}/student/buyitem', 'ClassroomsStudentController@buyItem'); // Policy protect
        Route::post('/{code}/student/buyequipment', 'ClassroomsStudentController@buyEquipment'); // Policy protect
        Route::post('/{code}/student/markchallenge', 'ClassroomsStudentController@markChallenge'); // Policy protect
        Route::post('/{code}/card/mark/{id}', 'ClassroomsStudentController@markCard'); // Policy protect
        
        // Behaviours
        Route::get('/{code}/behaviours', 'BehaviourController@index');
        Route::get('/{code}/behaviours/create', 'BehaviourController@create');
        Route::post('/{code}/behaviours', 'BehaviourController@store');
        Route::delete('/behaviour/{id}', 'BehaviourController@destroy');
        Route::get('/{code}/behaviours/{id}', 'BehaviourController@show');
        Route::patch('/behaviours/{id}', 'BehaviourController@update');
        
        // Levels
        Route::get('/{code}/levels', 'LevelsController@index');
        Route::post('/{code}/levels', 'LevelsController@store');
        Route::patch('/levels/{level}', 'LevelsController@update');
        Route::delete('/level/{id}', 'LevelsController@destroy');

        // Challenges
        Route::get('/{code}/challenges', 'ChallengesGroupController@index');
        Route::post('/{code}/challenges/group', 'ChallengesGroupController@store');
        Route::post('/{code}/challenges', 'ChallengesController@store');
        Route::post('/{code}/challenges/get', 'ChallengesController@index');
        Route::post('/challenges/image', 'ChallengesController@uploadImage');
        Route::delete('/challenges/{id}', 'ChallengesController@destroy');
        Route::patch('/{code}/challenges/{id}', 'ChallengesController@update');
        Route::post('/{code}/challenges/info', 'ChallengesController@getChallengesInfo');
        Route::post('/{code}/challenges/toggle', 'ChallengesController@toggle');
        
        // Attachment
        Route::post('/challenge/attachment', 'AttachmentController@store');
        Route::delete('/challenge/attachment/{id}', 'AttachmentController@destroy');

        // Shop
        Route::get('/{code}/shop', 'ShopController@index');
        Route::get('/{code}/shop/create', 'ShopController@create');
        Route::post('/{code}/shop', 'ShopController@store');
        Route::patch('/{code}/shop', 'ShopController@update');
        Route::patch('/{code}/shop/forsale', 'ShopController@updateForSale');
        Route::delete('/shop/{id}', 'ShopController@destroy');
        Route::get('/{code}/shop/{id}', 'ShopController@show');
        
        // Settings
        Route::patch('/{code}/setting', 'ClassroomsController@updateSetting');
        Route::post('/{code}/setting/updateavatar', 'ClassroomsStudentController@updateavatar'); // Policy protect

        // Maps
        Route::get('/{code}/maps', 'MapsController@index'); // Policy protect
        Route::get('/{code}/maps/{id}', 'MapsController@show'); // Policy protect
        Route::get('/{code}/maps/create', 'MapsController@create'); // Policy protect
        
    });

    Route::get('/utils/music', 'UtilsController@music');
    
    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');
});
