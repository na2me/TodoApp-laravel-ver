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


Route::get('/todo/login','TodoController@login');
Route::post('/todo/login','TodoController@authenticate');
Route::get('/todo/logout','TodoController@logout');
Route::get('/todo/register', 'TodoController@register');
Route::post('/todo/store/user', 'TodoController@storeUser');

Route::group(['middleware'=>['auth']],function (){

    Route::patch('/todo/toggle', 'TodoController@toggle');

    Route::resource('/todo','TodoController');

    Route::get('/todo/search','TodoController@show');
});


