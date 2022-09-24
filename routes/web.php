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


Route::GET('/employee/index', 'App\Http\Controllers\EmployeeController@index')->name('employee.index');
Route::GET('/employee/create', 'App\Http\Controllers\EmployeeController@create')->name('employee.create');
Route::POST('/employee/store', 'App\Http\Controllers\EmployeeController@store')->name('employee.store');
Route::GET('/employee/show/{id}', 'App\Http\Controllers\EmployeeController@show')->name('employee.show');
Route::GET('/employee/edit/{id}', 'App\Http\Controllers\EmployeeController@edit')->name('employee.edit');
Route::PATCH('/employee/update/{id}', 'App\Http\Controllers\EmployeeController@update')->name('employee.update');
Route::GET('/employee/status/{id}', 'App\Http\Controllers\EmployeeController@status')->name('employee.status');
Route::GET('/employee/delete/{id}', 'App\Http\Controllers\EmployeeController@destroy')->name('employee.delete');
Route::GET('/employee/view/{id}', 'App\Http\Controllers\EmployeeController@view')->name('employee.view');
