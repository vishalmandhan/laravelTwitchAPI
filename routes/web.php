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

Route::get('login/twitch', 'AuthLoginController@redirectToProvider');
Route::get('login/twitch/callback', 'AuthLoginController@handleProviderCallback');

Route::view('/addstreamer', 'addstreamer');
Route::post('streamer/favorite', 'StreamerController@favoriteStreamer');
Route::post('streamer/getLatestEvents', 'StreamerController@streamPageEvents');