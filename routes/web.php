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
    // Route::redirect('/', '/classroom');
    Route::get('/', 'HomeController@index');
    Route::get('/locale/{locale}', 'HomeController@locale');
    Route::get('/policy', 'HomeController@policy');

    // Miscellany
    Route::get('/contribute', 'MiscellanyController@contribute');

    // Login
    Route::get('/login/{locale}', 'Auth\LoginController@index');
    Route::get('/register/{locale}', 'Auth\RegisterController@index');

    // Classroom
    Route::prefix('classroom')->group(function () {
        Route::get('/', 'ClassroomsController@index')->name('classrooms');
        Route::post('/', 'ClassroomsController@store');
        Route::patch('/{code}', 'ClassroomsController@update');
        Route::get('create', 'ClassroomsController@create');
        Route::get('/{code}/edit', 'ClassroomsController@edit');
        Route::get('/join/{code}', 'ClassroomsController@join');
        Route::get('{code}', 'ClassroomsController@show');
        Route::get('{code}/clone', 'ClassroomsController@clone');
        Route::get('/{code}/regenerate', 'ClassroomsController@regenerate');
        Route::delete('{code}', 'ClassroomsController@destroy');

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
        Route::post('/students/toggle', 'StudentController@toggle');
        Route::get('/{code}/student/{id}', 'StudentController@show');
        Route::post('/{code}/student/name', 'StudentController@updateName');
        Route::post('/{code}/student/changecharacter', 'StudentController@changeCharacter');
        Route::delete('/student/behaviour', 'StudentController@deleteBehaviour');
        Route::post('/student/behaviour', 'StudentController@addBehaviour');
        Route::delete('/student/logentry', 'StudentController@deleteLog');
        Route::patch('/student/inventory', 'InventoryController@update');
        Route::delete('/{code}/student/{id}', 'StudentController@destroy');
        
        // Student View
        Route::get('/show/{code}', 'ClassroomsStudentController@show');
        Route::get('/show/{code}/users', 'ClassroomsStudentController@index');
        Route::get('/show/{code}/challenges', 'ClassroomsStudentController@challenges');
        Route::get('/show/{code}/map', 'ClassroomsStudentController@map');
        Route::get('/show/{code}/rules', 'ClassroomsStudentController@rules');
        Route::get('/show/{code}/licenses', 'ClassroomsStudentController@licenses');
        Route::post('/{code}/student/useitem', 'ClassroomsStudentController@useItem');
        Route::post('/{code}/student/buyitem', 'ClassroomsStudentController@buyItem');
        Route::post('/{code}/student/buyequipment', 'ClassroomsStudentController@buyEquipment');
        Route::post('/{code}/student/markchallenge', 'ClassroomsStudentController@markChallenge');
        Route::post('/{code}/card/mark/{id}', 'ClassroomsStudentController@markCard');
        
        // Behaviours
        Route::get('/{code}/behaviours', 'BehaviourController@index');
        Route::get('/{code}/behaviours/create', 'BehaviourController@create');
        Route::post('/{code}/behaviours', 'BehaviourController@store');
        Route::delete('/behaviour/{id}', 'BehaviourController@destroy');
        Route::get('/{code}/behaviours/{id}', 'BehaviourController@show');
        Route::patch('/behaviours/{id}', 'BehaviourController@update');
        Route::get('/{code}/behaviours/import/default', 'BehaviourController@importDefault');
        
        // Badges
        Route::get('/{code}/badges', 'BadgeController@index');
        Route::get('/{code}/badges/create', 'BadgeController@create');
        Route::post('/{code}/badges', 'BadgeController@store');
        Route::post('/student/badge', 'BadgeController@toggle');
        Route::delete('/badge/{id}', 'BadgeController@destroy');
        Route::get('/{code}/badges/{id}', 'BadgeController@show');
        Route::patch('/badges/{id}', 'BadgeController@update');
        
        // Levels
        Route::get('/{code}/levels', 'LevelsController@index');
        Route::post('/{code}/levels', 'LevelsController@store');
        Route::patch('/levels/{level}', 'LevelsController@update');
        Route::delete('/level/{id}', 'LevelsController@destroy');

        // Challenges
        Route::get('/{code}/challenges', 'ChallengesGroupController@index');
        Route::post('/{code}/challenges/group', 'ChallengesGroupController@store');
        Route::delete('/challenges/group/{id}', 'ChallengesGroupController@destroy');
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
        
        // Question
        Route::post('/challenge/question', 'QuestionController@store');
        Route::delete('/challenge/question/{id}', 'QuestionController@destroy');
        Route::post('/question/answer', 'QuestionController@answer');
        
        // Comment
        Route::post('/challenge/comment', 'CommentController@store');
        Route::delete('/challenge/comment/{id}', 'CommentController@destroy');

        // Rules
        Route::get('/{code}/rules', 'RulesController@show');
        Route::post('/default/rules', 'RulesController@default');
        Route::patch('/{code}/rules', 'RulesController@update');

        // Shop
        Route::get('/{code}/shop', 'ShopController@index');
        Route::get('/{code}/shop/create', 'ShopController@create');
        Route::post('/{code}/shop', 'ShopController@store');
        Route::patch('/{code}/shop', 'ShopController@update');
        Route::patch('/{code}/shop/forsale', 'ShopController@updateForSale');
        Route::delete('/shop/{id}', 'ShopController@destroy');
        Route::get('/{code}/shop/{id}', 'ShopController@show');
        
        // Settings
        Route::get('/{code}/settings', 'SettingsController@index');
        Route::patch('/{code}/setting', 'SettingsController@updateSetting');
        Route::post('/{code}/setting/updateavatar', 'ClassroomsStudentController@updateavatar');
        Route::post('/{code}/invite', 'SettingsController@invite'); 
        Route::delete('/{code}/teacher/{id}', 'SettingsController@destroy');
        
        // Events
        Route::get('/{code}/events', 'EventController@index');
        Route::post('/{code}/events/disable', 'EventController@disable');
        Route::get('/{code}/event/random', 'EventController@show');
        Route::post('/events/add', 'EventController@add');
        Route::post('/events/edit', 'EventController@update');
        Route::delete('/events/{id}', 'EventController@destroy');

        // Maps
        Route::get('/{code}/maps', 'MapsController@index');
        Route::get('/{code}/maps/create', 'MapsController@create');
        Route::post('/{code}/maps', 'MapsController@store');
        Route::delete('/maps/{id}', 'MapsController@destroy');
        Route::get('/{code}/maps/{id}', 'MapsController@show');
        Route::patch('/maps/{id}', 'MapsController@update');
        
        // Evaluation
        Route::get('/{code}/evaluation/report', 'EvaluationController@report');
        Route::get('/{code}/evaluation', 'EvaluationController@index');
        Route::get('/evaluation/{id}/grade', 'EvaluationController@grade');
        Route::post('/evaluation/student/rubric', 'EvaluationController@getRubric');
        Route::post('/evaluation/rubric', 'EvaluationController@getShowRubric');
        Route::post('/evaluation/{id}/evaluate/rubric', 'EvaluationController@evaluateRubric');
        Route::post('/evaluation/{id}/evaluate', 'EvaluationController@evaluate');
        Route::post('/{code}/evaline', 'EvaluationController@store');
        Route::delete('/evaline/{id}', 'EvaluationController@destroy');
        Route::get('/{code}/rubrics', 'RubricController@index');
        Route::get('/{code}/rubric/create', 'RubricController@create');
        Route::post('/{code}/rubric', 'RubricController@store');
        Route::patch('/{code}/rubric/{id}', 'RubricController@update');
        Route::get('/{code}/rubric/{id}', 'RubricController@edit');

        //Tags
        Route::post('/{code}/tag', 'TagController@store');
        Route::patch('/{code}/tag', 'TagController@update');
        Route::delete('/tag/{id}', 'TagController@destroy');
        
        // Pets
        Route::get('/{code}/pets', 'PetsController@index');

        // Utils
        Route::get('/{code}/utils/meter', 'UtilsController@showMeter');
        Route::post('/{code}/utils/meter', 'UtilsController@meter');
        Route::post('/{code}/utils/massive', 'UtilsController@massive');
        Route::get('/utils/icon-packs', 'UtilsController@iconPacks');
        Route::get('/utils/icon-packs/{category}', 'UtilsController@iconPack');
    });

    // Utils
    Route::get('/utils/music', 'UtilsController@music');

    // User
    Route::get('/user/challenges', 'ChallengesController@getUserChallenges');
    Route::post('/user/challenges/import/{id}', 'ChallengesController@importChallenge');
    
    // Profile
    Route::get('/profile/promote', 'ProfileController@promote');
    Route::get('/profile', 'ProfileController@index');
    Route::patch('/profile/update', 'ProfileController@update');

    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');
});
