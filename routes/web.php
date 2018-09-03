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

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/login','Admin\LoginController@showLoginForm');
Route::get('admin/logout','Admin\LoginController@logout');
Route::post('admin/login','Admin\LoginController@LoginIng');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'auth:admin']], function () {
    Route::get('/','IndexController@index');
    Route::get('welcome','IndexController@welcome');
});