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


//Auth::routes();
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/auth/google/redirect', 'Auth\GoogleController@redirect')->name('google-login');
Route::get('/auth/google/callback', 'Auth\GoogleController@callback');

Route::get('/', 'WelcomeController@welcome')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/standup/send', 'StandupController@send')->name('standup-send');
    Route::get('/standup/thanks', 'StandupController@thanks')->name('standup-thanks');
});
