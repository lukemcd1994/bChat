<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('chats', 'ChatSessionController', [
    'only' => ['index', 'store']
]);
//
//Route::resource('/messages', 'MessageController', [
//    'only' => ['index', 'store']
//]);

Route::post('/send', 'MessageController@store');
Route::post('/messages', 'MessageController@index');