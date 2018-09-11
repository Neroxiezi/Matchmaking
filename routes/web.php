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

/************* 公共路由 **************/
/*Route::post('upload','UploadController@store');*/


Route::get('admin/login','Admin\LoginController@showLoginForm');
Route::get('admin/logout','Admin\LoginController@logout');
Route::post('admin/login','Admin\LoginController@LoginIng');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'auth:admin']], function () {
    Route::get('/','IndexController@index');
    Route::get('welcome','IndexController@welcome');
    Route::post('member/photo','MemberController@photo_upload');
    Route::resource('member','MemberController');
    Route::resource('tag','TagController');
});