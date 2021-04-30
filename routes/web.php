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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/teacher/all','TeacherController@index')->name('teacher.index');
Route::post('/teacher/store/','TeacherController@store')->name('teacher.store');
Route::get('/teacher/edit/{id}','TeacherController@edit')->name('teacher.edit');
Route::post('/teacher/update/{id}','TeacherController@update')->name('teacher.update');
Route::get('/teacher/delete/{id}','TeacherController@delete')->name('teacher.delete');
