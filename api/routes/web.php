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

Route::get ('/search/track/{title}/{limit}', 'SearchController@tracks')->name ('searchTrack');
Route::get ('/search/artist/{title}/{limit}', 'SearchController@artists')->name ('searchArtist');
