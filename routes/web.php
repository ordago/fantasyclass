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

Route::get('/locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es', 'ca'])) {
        abort(404);
    }
    \App::setLocale($locale);

    return back()->withInput();
});


Route::redirect('/', '/classrooms');

// Classrooms
Route::get('/classrooms', 'ClassroomsController@index');
Route::get('/classrooms/create', 'ClassroomsController@create');

Auth::routes(['verify' => true]);

