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

Route::get('/', "RentSearchController@index")->name("home");
Route::post('/property_count', "RentSearchController@propertyCount")->name("property.count");
Route::get('/search_result', "RentSearchController@searchResult")->name("search.result");
