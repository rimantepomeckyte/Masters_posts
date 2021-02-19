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

Route::get('/', 'MasterController@index');
Route::get('/add-company', 'CompanyController@addCompany');
Route::post('/addingCompany', 'CompanyController@addingCompany');
Route::get('/add-specialization', 'SpecializationController@addSpecialization');
Route::post('/addingSpecialization', 'SpecializationController@addingSpecialization');
Route::get('/add-master', 'MasterController@addMaster');
Route::post('/store', 'MasterController@store');
Route::get('/master/{master}', 'MasterController@showFull');
Route::get('/edit/master/{master}', 'MasterController@editMaster');
Route::patch('/storeupdate/{master}', 'MasterController@storeUpdate');
Route::get('/user/{user}', 'MasterController@showByUser');
Route::get('/delete/master/{master}', 'MasterController@delete');
Route::post('/review', 'ReviewController@addingReview');
Route::get('/search', 'SearchController@index');



Auth::routes();

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
