<?php

use Illuminate\Support\Facades\Auth;
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
    Route::get('/cookies', 'HomeController@cookies');

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
        Route::post('/{code}/regenerate', 'ClassroomsController@regenerate');
        Route::delete('{code}', 'ClassroomsController@destroy');
        Route::post('/{code}/reward', 'ClassroomsController@reward');
        Route::post('/{code}/add2collection', 'ClassroomsController@add2collection');
        Route::delete('/{code}/removeMedia/{id}', 'ClassroomsController@removeMedia');

        // Cards
        Route::delete('/card/{id}', 'CardsController@destroy');
        Route::get('/card/disable/{id}', 'CardsController@toggleDisable');
        Route::get('/card/automatic/{id}', 'CardsController@toggleAutomatic');
        Route::get('/{code}/cards', 'CardsController@index');
        Route::get('/{code}/card/random', 'CardsController@random');
        Route::post('/{code}/card/assign', 'CardsController@assign');
        Route::post('/{code}/card/import', 'CardsController@import');
        Route::get('/{code}/cards/import/default', 'CardsController@importDefault');
        Route::get('/{code}/cards/create', 'CardsController@create');
        Route::post('/{code}/cards', 'CardsController@store');
        Route::get('/{code}/cards/{id}', 'CardsController@show');
        Route::patch('/cards/{id}', 'CardsController@update');
        Route::post('/card/usedelete/{id}', 'CardsController@useDelete');
        Route::post('/card/usedelete/bypass/{id}', 'CardsController@useDeleteAdmin');

        // Groups
        Route::get('/{code}/groups', 'GroupsController@index');
        Route::post('/{code}/groups/create', 'GroupsController@store');
        Route::patch('/{code}/groups/{action}', 'GroupsController@update');
        Route::delete('/groups/{id}', 'GroupsController@destroy');
        Route::post('/{code}/group/reward', 'GroupsController@reward');
        
        // Students
        Route::get('/student/{id}/get', 'StudentController@getStudent');
        Route::get('/{code}/students/add', 'StudentController@create');
        Route::get('/{code}/students/add/{flag}', 'StudentController@create');
        Route::post('/students/', 'StudentController@store');
        Route::post('/students/getusername', 'StudentController@getUsername');
        Route::post('/students/update', 'StudentController@update');
        Route::post('/students/toggle', 'StudentController@toggle');
        Route::get('/{code}/student/{id}', 'StudentController@show');
        Route::get('/{code}/student/{id}/section/{section}', 'StudentController@show');
        Route::post('/{code}/student/name', 'StudentController@updateName');
        Route::post('/{code}/student/changecharacter', 'StudentController@changeCharacter');
        Route::delete('/student/behaviour', 'StudentController@deleteBehaviour');
        Route::post('/student/behaviour', 'StudentController@addBehaviour');
        Route::delete('/student/logentry', 'StudentController@deleteLog');
        Route::patch('/student/inventory', 'InventoryController@update');
        Route::delete('/{code}/student/{id}', 'StudentController@destroy');
        Route::post('/{code}/student/show', 'StudentController@showAsStudent');
        Route::post('/{code}/student/assignpet', 'StudentController@assignPet');
        Route::get('/{code}/student/{id}/report', 'StudentController@getStudentReport');
        Route::get('/{code}/students/report', 'StudentController@getStudentsReport');
        Route::get('/log/{id}', 'StudentController@getStudentLog');
        
        
        Route::post('/{code}/students/get', 'ClassroomsController@getStudentPage');
        // Route::post('/{code}/students/pending', 'ClassroomsController@pendingCards');
        Route::get('/{code}/students/all', 'ClassroomsController@getAllStudents');

        // Student View
        Route::get('/show/{code}', 'ClassroomsStudentController@show');
        Route::get('/show/{code}/section/{section}', 'ClassroomsStudentController@show');
        Route::get('/show/{code}/users', 'ClassroomsStudentController@index');
        Route::get('/show/{code}/challenges', 'ClassroomsStudentController@challenges');
        Route::get('/show/{code}/challenges/{permalink}', 'ClassroomsStudentController@getChallenge');
        Route::get('/show/{code}/map', 'ClassroomsStudentController@map');
        Route::get('/show/{code}/rules', 'ClassroomsStudentController@rules');
        Route::get('/show/{code}/licenses', 'ClassroomsStudentController@licenses');
        Route::post('/{code}/student/useitem', 'ClassroomsStudentController@useItem');
        Route::post('/{code}/student/buyitem', 'ClassroomsStudentController@buyItem');
        Route::post('/{code}/student/card/buy', 'ClassroomsStudentController@buyCard');
        Route::post('/{code}/student/collection/buy', 'ClassroomsStudentController@buyPackCollectionables');
        Route::post('/{code}/student/collection/claim', 'ClassroomsStudentController@claimReward');
        Route::get('/{code}/exchange/get', 'ClassroomsStudentController@getExchange');
        Route::post('/{code}/exchange', 'ClassroomsStudentController@doExchange');
        Route::post('/{code}/exchange/delete', 'ClassroomsStudentController@removeExchange');
        Route::post('/{code}/student/exchangeCollectible', 'ClassroomsStudentController@exchangeCollectible');
        Route::post('/{code}/student/skills/buy', 'ClassroomsStudentController@buySkill');
        Route::post('/{code}/student/skills/use', 'ClassroomsStudentController@useSkill');
        Route::post('/{code}/student/skills/delete', 'ClassroomsStudentController@deleteSkill');
        Route::post('/{code}/student/buypet', 'ClassroomsStudentController@buyPet');
        Route::post('/{code}/student/buyequipment', 'ClassroomsStudentController@buyEquipment');
        Route::post('/{code}/student/assignequipment', 'StudentController@assignEquipment');
        Route::post('/{code}/student/markchallenge', 'ClassroomsStudentController@markChallenge');
        Route::post('/{code}/student/passwordChallenge', 'ClassroomsStudentController@passwordChallenge');
        Route::post('/{code}/card/mark/{id}', 'ClassroomsStudentController@markCard');
        Route::post('/challenge/rate', 'ClassroomsStudentController@addRating');
        Route::post('/{code}/send/money', 'ClassroomsStudentController@sendMoney');
        Route::post('/{code}/studentsview/get', 'ClassroomsStudentController@getStudentPage');
        Route::post('/{code}/craft', 'ClassroomsStudentController@craft');
        Route::post('/student/pet/feed', 'ClassroomsStudentController@feed');
        Route::post('/student/equipment/repair', 'ClassroomsStudentController@repair');
        Route::post('/{code}/shop/sell', 'ClassroomsStudentController@sellObjects');


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
        Route::patch('/{code}/badges', 'BadgeController@store');
        Route::post('/student/badge', 'BadgeController@toggle');
        Route::delete('/badge/{id}', 'BadgeController@destroy');
        Route::get('/{code}/badges/{id}', 'BadgeController@show');
        Route::patch('/badges/{id}', 'BadgeController@update');

        // Levels
        Route::post('/{code}/level/add', 'LevelsController@createNew');
        Route::post('/{code}/levels/getRewards', 'LevelsController@getRewards');
        Route::get('/{code}/levels', 'LevelsController@index');
        Route::post('/{code}/levels', 'LevelsController@store');
        Route::patch('/levels/{level}', 'LevelsController@update');
        Route::patch('/levels/reward/{level}', 'LevelsController@updateRewards');
        Route::delete('/level/{id}', 'LevelsController@destroy');
  
        // Roles
        Route::post('/{code}/role/add', 'RoleController@createNew');
        Route::get('/{code}/roles', 'RoleController@index');
        Route::get('/{code}/roles/info', 'RoleController@getRoleInfo');
        Route::post('/{code}/roles/accept', 'RoleController@accept');
        Route::get('/{code}/roles/default', 'RoleController@insertDefault');
        Route::delete('/{code}/roles/remove', 'RoleController@removeAssign');
        Route::post('/{code}/roles', 'RoleController@store');
        Route::patch('/role/{role}', 'RoleController@update');
        Route::delete('/role/{id}', 'RoleController@destroy');

        // Documents
        Route::get('/{code}/docmgr', 'DocumentManagerController@index');
        Route::post('/{code}/docmgr/group', 'DocumentManagerController@store');
        Route::post('/{code}/docmgr/group/order', 'DocumentManagerController@order');
        Route::post('/{code}/documents/get', 'DocumentController@index');
        Route::delete('/documents/group/{id}', 'DocumentManagerController@destroy');
        
        Route::post('/{code}/docmgr/document', 'DocumentController@store');
        Route::patch('/{code}/docmgr/document', 'DocumentController@update');
        Route::patch('/{code}/document', 'DocumentController@updateProp');
        Route::delete('/document/{id}', 'DocumentController@destroy');
        Route::post('/{code}/docmgr/documents/order', 'DocumentController@order');
        Route::post('/{code}/docmgr/documents/mark', 'DocumentController@mark');
        
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
        Route::post('/{code}/evaluable/getInfo', 'ChallengesController@getEvaluableInfo');
        Route::post('/{code}/challenges/toggle', 'ChallengesController@toggle');
        Route::post('/{code}/challenges/update', 'ChallengesController@updateStudents');
        Route::post('/{code}/challenges/groups/update', 'ChallengesController@updateGroups');
        Route::post('/{code}/challenges/toggleProp', 'ChallengesController@toggleProp');
        Route::get('/{code}/challenges/all', 'ChallengesController@getAllChallenges');
        Route::post('/challenge/getlink', 'ChallengesController@getChallengeLink');
        Route::post('/challenge/map', 'ChallengesController@getMapCode');
        Route::get('/challenge/disable/{id}', 'ChallengesController@toggleDisable');
        

        // Attachment
        Route::post('/challenge/attachment', 'AttachmentController@store');
        Route::delete('/challenge/attachment/{id}', 'AttachmentController@destroy');

        // Questions
        Route::post('/challenge/question', 'QuestionController@store');
        Route::post('/question/add', 'QuestionController@store');
        Route::delete('/challenge/question/{id}', 'QuestionController@destroy');
        Route::delete('/questions/{id}', 'QuestionController@destroy');
        Route::post('/question/answer', 'QuestionController@answer');
        Route::get('/{code}/questions/{bank}', 'QuestionController@index');

        // Question bank
        Route::get('/{code}/questions', 'QuestionBankController@index');
        Route::post('/{code}/questions', 'QuestionBankController@store');
        Route::delete('/bank/{id}', 'QuestionBankController@destroy');
        Route::post('/{code}/bank/download', 'QuestionBankController@downloadQuestionBank');
        Route::post('/question/addImage', 'QuestionBankController@addImage');
        
        // Battles
        Route::get('/{code}/battles', 'BattleController@index');
        Route::post('/{code}/group/reward', 'ClassroomsController@rewardGroup');
        
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
        Route::post('/{code}/setting/forget', 'SettingsController@forgetSetting');
        Route::post('/{code}/setting/updateavatar', 'ClassroomsStudentController@updateavatar');
        Route::post('/{code}/invite', 'SettingsController@invite');
        Route::delete('/{code}/teacher/{id}', 'SettingsController@destroy');
        Route::post('/{code}/teacher/admin', 'SettingsController@makeAdmin');
        Route::post('/{code}/settings/reset', 'SettingsController@reset');
        Route::post('/{code}/settings/themes', 'SettingsController@themes');
        Route::get('/{code}/toggleClassNotifications', 'SettingsController@toggleClassNotifications');
        Route::post('/{code}/settings/import', 'SettingsController@import');

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

        // Evaluable Group
        Route::get('/{code}/evaluation', 'EvaluablesGroupController@index');
        Route::post('/{code}/evaluation/group', 'EvaluablesGroupController@store');
        Route::delete('/evaluation/group/{id}', 'EvaluablesGroupController@destroy');

        // Evaluation
        Route::post('/{code}/evaluation/get', 'EvaluationController@index');
        Route::post('/{code}/evaluation', 'EvaluationController@store');
        Route::post('/{code}/evaluation/edit', 'EvaluationController@update');
        Route::delete('/evaluation/{id}', 'EvaluationController@destroy');

        Route::get('/evaluation/{id}/grade', 'EvaluationController@grade');
        Route::post('/evaluation/{id}/evaluate', 'EvaluationController@evaluate');
        Route::get('/{code}/evaluation/report', 'EvaluationController@report');

        Route::post('/evaluation/student/rubric', 'EvaluationController@getRubric');
        Route::post('/evaluation/rubric', 'EvaluationController@getShowRubric');
        Route::post('/evaluation/{id}/evaluate/rubric', 'EvaluationController@evaluateRubric');
        Route::get('/{code}/rubrics', 'RubricController@index');
        Route::get('/{code}/rubric/create', 'RubricController@create');
        Route::post('/{code}/rubric', 'RubricController@store');
        Route::patch('/{code}/rubric/{id}', 'RubricController@update');
        Route::get('/{code}/rubric/{id}', 'RubricController@edit');
        Route::post('/evaluation/exportEvaluationReport/', 'EvaluationController@exportEvaluationReport');

        //Tags
        Route::post('/{code}/tag', 'TagController@store');
        Route::patch('/{code}/tag', 'TagController@update');
        Route::delete('/tag/{id}', 'TagController@destroy');

        // Blogs
        Route::post('/{code}/blog', 'BlogController@store');
        Route::post('/{code}/post', 'BlogController@storePost');
        Route::patch('/{code}/post', 'BlogController@editPost');
        Route::post('/{code}/posts', 'BlogController@index');
        Route::delete('/{code}/blog/{id}', 'BlogController@destroy');
        Route::delete('/{code}/blogp/{id}', 'BlogController@destroyPublic');
        Route::delete('/{code}/post/{id}', 'BlogController@destroyPost');
        
        // Pets
        Route::get('/{code}/pets', 'PetsController@index');
        Route::get('/{code}/pets/get', 'PetsController@get');
        Route::post('/{code}/pets', 'PetsController@store');
        Route::patch('/{code}/pets', 'PetsController@update');
        Route::delete('/pets/{id}', 'PetsController@destroy');
        Route::get('/pets/{id}/for-sale', 'PetsController@toggle');
        
        // Monsters
        Route::get('/{code}/monsters', 'MonsterController@index');
        Route::post('/{code}/monsters', 'MonsterController@store');
        Route::patch('/{code}/monsters', 'MonsterController@update');
        Route::delete('/monsters/{id}', 'MonsterController@destroy');
        Route::post('/monsters/fight', 'MonsterController@battle');
        
        // Skills
        Route::get('/{code}/skills', 'SkillsController@index');
        Route::get('/{code}/skills/get', 'SkillsController@get');
        Route::post('/{code}/skill', 'SkillsController@store');
        Route::patch('/{code}/skill', 'SkillsController@update');
        Route::delete('/skills/{id}', 'SkillsController@destroy');
        Route::get('/{code}/skills/import', 'SkillsController@importDefault');
        
        // Collections
        Route::get('/{code}/collections', 'CollectionController@index');
        Route::post('/{code}/collections', 'CollectionController@store');
        Route::post('/{code}/collectionable', 'CollectionableController@store');
        Route::delete('/collectionable/{id}', 'CollectionableController@destroy');
        Route::post('/{code}/collectionable/edit', 'CollectionableController@update');
        Route::delete('/collections/{id}', 'CollectionController@destroy');
        Route::post('/{code}/collections/edit', 'CollectionController@update');
        Route::get('/collection/disable/{id}', 'CollectionController@toggleDisable');

        
        // Utils
        Route::post('/{code}/utils/impostor', 'UtilsController@impostor');
        Route::delete('/{code}/utils/impostor/clear', 'UtilsController@impostorClear');
        Route::get('/{code}/utils/meter', 'UtilsController@showMeter');
        Route::post('/{code}/utils/meter', 'UtilsController@meter');
        Route::post('/{code}/utils/massive', 'UtilsController@massive');
        Route::get('/{code}/utils/icon-packs', 'UtilsController@iconPacks');
        Route::get('/utils/icon-packs/{category}', 'UtilsController@iconPack');
        Route::get('/utils/get-shop', 'UtilsController@getShop');
        Route::get('/{code}/utils/exportConfidentialDataStudent', 'UtilsController@exportConfidentialDataStudent');
        Route::post('/{code}/get/objects', 'UtilsController@getObjects');
        Route::get('/{code}/random/student', 'UtilsController@getRandomStudent');
        
        Route::get('/{code}/videochats/get', 'VideochatController@index');
        Route::post('/{code}/videochat', 'VideochatController@store');
        Route::delete('/videochat/{id}', 'VideochatController@destroy');
        Route::patch('/videochat/toggle', 'VideochatController@toggle');
        Route::post('/videochat/toggle', 'VideochatController@toggle');
        Route::post('/videochat/notify', 'VideochatController@notify');
        Route::post('/videochat/groups', 'VideochatController@updateGroups');
        
        Route::get('/{code}/attendance', 'AttendanceController@index');
        Route::get('/{code}/attendance/get', 'AttendanceController@getEvents');
        Route::post('/{code}/attendance/createEvent', 'AttendanceController@store');

    });
    
    // External
    Route::get('/external/{type}/{code}', 'UtilsController@externalLink');
    Route::get('/external/check/{type}/{code}', 'MiscellanyController@externalCheck');


    // Utils
    Route::get('/utils/music', 'UtilsController@music');
    Route::get('/utils/online', 'UtilsController@online');
    Route::get('/utils/get/themes', 'UtilsController@getThemes');

    // User
    Route::get('/user/challenges', 'ChallengesController@getUserChallenges');
    Route::post('/user/challenges/import/{id}', 'ChallengesController@importChallenge');

    // Banks
    Route::get('/user/cards', 'CardsController@getUserCards');
    Route::post('/card/share', 'CardsController@share');
    Route::get('/card/share/get', 'CardsController@getSharedCards');
    
    Route::post('/levels/share', 'LevelsController@share');
    Route::get('/levels/share/get', 'LevelsController@getSharedLevels');
    Route::post('/levels/import', 'LevelsController@importLevels');
    
    Route::post('/collections/share', 'CollectionController@share');
    Route::get('/collections/share/get', 'CollectionController@getSharedCollections');
    Route::post('/collections/import', 'CollectionController@importCollection');
    
    Route::post('/pets/share', 'PetsController@share');
    Route::get('/pets/share/get', 'PetsController@getSharedPets');
    Route::post('/pets/import', 'PetsController@importPet');

    // Profile
    Route::get('/profile/promote', 'ProfileController@promote');
    Route::get('/profile', 'ProfileController@index');
    Route::patch('/profile/update', 'ProfileController@update');

    // Socialite
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');
    Route::get('/google/classroom/link/{code}', 'SocialController@googleClassroom');
    Route::get('/google/classroom/unlink', 'SocialController@unlinkGoogleClassroom');
    Route::get('/google/drive/link/{code}', 'SocialController@addGoogleDrive');
    Route::get('/google/drive/unlink', 'SocialController@unlinkGoogleDrive');
    
    // Google Classroom
    Route::get('/google/classroom/list/courses', 'ServicesController@classroomList');
    Route::get('/google/classroom/list/{courseId}/students', 'ServicesController@usersList');
    
    // Google Drive
    Route::get('/google/drive', 'StorageController@gDrive');
    Route::post('/google/drive/createFolder', 'StorageController@createFolder');
    Route::post('/storage/upload/{challenge}', 'StorageController@uploadFile');
    Route::get('/google/drive/status', function () {return Auth()->user()->g_folder ? true: false; });
    
    // Tasks
    Route::delete('/tasks/delete/{task}', 'TasksController@destroy');
    
    // Google Classroom
    Route::get('/offline', function () {return view('vendor.laravelpwa.offline');});
    

    // Notifications
    Route::post('/push','NotificationController@store');
    Route::post('/classroom/{code}/push/all','NotificationController@sendAll');
    Route::post('/classroom/{code}/push','NotificationController@send');
    Route::post('/notification/delete','NotificationController@destroy');
    Route::post('/notification/delete/all','NotificationController@destroyAll');

    // inbox
    Route::get('/inbox', 'UtilsController@showChat');
    Route::get('/inbox/token', 'UtilsController@getFirebaseToken');
    Route::post('/users/chat', 'UtilsController@getUserChatInfo');
    Route::post('/chat/notify', 'UtilsController@notifyChat');
    Route::post('/chat/send2admin', 'UtilsController@send2admin');
    
    // Mobile
    Route::get('/mobile', 'MiscellanyController@mobile');
    
    // Demo
    Route::get('/demo', function () { return redirect('/'); });
    // Route::get('/demo', 'MiscellanyController@demo');

    // Tutorial
    Route::get('/tutorial', function () {return redirect()->away(env('TUTORIAL'));});
    
});
