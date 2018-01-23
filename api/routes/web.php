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

Route::get ('/search', 'SearchController@index')->name ('search');
Route::get ('/album', 'AlbumController@index')->name ('album');
Route::get ('/artist', 'ArtistController@artist')->name ('artist');
Route::get ('/artist/albums', 'ArtistController@albums');
Route::get ('/track', 'TrackController@index')->name ('track');
Route::get ('/browse', 'PlaylistController@index')->name ('playlist');
