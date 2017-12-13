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

use App\Jobs\CheckPreferences;
use Carbon\Carbon;

Route::get('/', function () {
    return view('user.create');
});

Route::post('preferences', 'PreferencesController@store')->name('preferences.store');
Route::get('preferences/{token}', 'PreferencesController@edit')->name('preferences.edit');
Route::patch('preferences/{token}', 'PreferencesController@update');

Route::get('weather/', 'WeatherController@update');

