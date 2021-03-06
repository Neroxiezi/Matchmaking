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

Route::get('/', 'HomeController@index');
Route::get('video/{course}', 'HomeController@course_info');

/************* 公共路由 **************/
Route::get('admin/login','Admin\LoginController@showLoginForm');
Route::get('admin/logout','Admin\LoginController@logout');
Route::post('admin/login','Admin\LoginController@LoginIng');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'auth:admin']], function () {
    Route::get('/','IndexController@index');
    Route::get('welcome','IndexController@welcome');
    Route::post('member/photo','MemberController@photo_upload');
    Route::resource('member','MemberController');
    Route::resource('tag','TagController');
    Route::post('course/img','CourseController@photo_upload');
    Route::post('course/video','CourseController@video_upload');
    Route::resource('course','CourseController');
});