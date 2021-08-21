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
Route::get('/activate' , '\App\Http\Controllers\API\Auth\AccountController@activate')->middleware(['speed']);
Route::get("/export/users" , '\App\Http\Controllers\API\UserController@export')->middleware(['speed']);

Route::get('/{vue_capture?}', 'AppController@index')
    ->middleware(['speed'])
    ->where('vue_capture', '[\/\w\.\,\-]*');
