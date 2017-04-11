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

Route::get('/home', 'HomeController@index');

Route::resource('message','MessageController');
Route::get('/sent',['uses'=>'MessageController@sent','as'=>'message.sent']);

Route::get('/profile',['uses'=>'UserController@profile','as'=>'user.profile']);
Route::post('/updateProfile',['uses'=>'UserController@updateProfile','as'=>'updateprofile']);

Route::post('/reply',['uses'=>'MessageController@reply','as'=>'message.reply']);
Route::get('/excel',['uses'=>'MessageController@excelimportexport','as'=>'message.importexport']);
Route::post('/importexcel',['uses'=>'MessageController@import','as'=>'message.importexcel']);
Route::get('/exportexcel',['uses'=>'MessageController@export','as'=>'message.exportexcel']);


