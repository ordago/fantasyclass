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
//Route::get('/', 'HomeController@index')->name('home');
//Route::get('/home', 'HomeController@index')->name('home');

// Localization
Route::get('/locale/{locale}', function ($locale){

    if (! in_array($locale, Config::get('app.locales'))) {
        abort(404);
    }
    Session::put('locale', $locale);
    return redirect()->back();
});


Route::redirect('/', '/classrooms');

// Classrooms
Route::get('/classrooms', 'ClassroomsController@index');
Route::get('/classrooms/create', 'ClassroomsController@create');

Auth::routes(['verify' => true]);

