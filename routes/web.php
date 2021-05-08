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

Route::get('/', function () {
	return view('welcome');
});

Route::get('/event/{imei?}', 'EventController@index');

Route::get('/upload', function () {
	return view('event_file_upload');
});

Route::post('/upload', 'EventController@upload');

Route::get('/apiHistory/{imei?}', 'ApiHistoryController@index');

Route::get('/apiHistoryDetail/{id?}', 'ApiHistoryController@detail');