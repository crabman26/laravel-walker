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

Route::resource('ads','AdsController');
Route::resource('categories','CategoriesController');

//Ajax implementation
Route::get('adsajax','AdsAjaxController@index')->name('adsajax');
Route::get('adsajax/getdata','AdsAjaxController@getdata')->name('adsajax.getdata');

Route::get('categoriesajax','CategoriesAjaxController@index')->name('categoriesajax');
Route::get('categoriesajax/getdata','CategoriesAjaxController@getdata')->name('categoriesajax.getdata');
