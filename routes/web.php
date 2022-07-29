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
Route::get('/', 'IndexController@index')->name('webIndex');
Route::get('/index.html', 'IndexController@index')->name('webIndex');
Route::get('/store.html', 'IndexController@store')->name('webStore');
Route::get('/about_us.html', 'IndexController@abuotUs')->name('webAbuotUs');
Route::post('/apply', 'IndexController@putQuestion');
Route::get('/test', 'TestController@test');

