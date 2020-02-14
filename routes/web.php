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
Route::post('adsajax/postdata','AdsAjaxController@postdata')->name('adsajax.postdata');
Route::get('adsajax/fetchdata','AdsAjaxController@fetchdata')->name('adsajax.fetchdata');
Route::get('adsajax/removedata', 'AdsAjaxController@removedata')->name('adsajax.removedata');
Route::get('adsajax/massremove', 'AdsAjaxController@massremove')->name('adsajax.massremove');

Route::get('categoriesajax','CategoriesAjaxController@index')->name('categoriesajax');
Route::get('categoriesajax/getdata','CategoriesAjaxController@getdata')->name('categoriesajax.getdata');
Route::post('categoriesajax/postdata','CategoriesAjaxController@postdata')->name('categoriesajax.postdata');
Route::get('categoriesajax/fetchdata','CategoriesAjaxController@fetchdata')->name('categoriesajax.fetchdata');
Route::get('categoriesajax/removedata','CategoriesAjaxController@removedata')->name('categoriesajax.removedata');
Route::get('categoriesajax/massremove','CategoriesAjaxController@massremove')->name('categoriesajax.massremove');

Route::get('regionajax','RegionAjaxController@index')->name('regionajax');
Route::get('regionajax/getdata','RegionAjaxController@getdata')->name('regionajax.getdata');
Route::post('regionajax/postdata','RegionAjaxController@postdata')->name('regionajax.postdata');
Route::get('regionajax/fetchdata','RegionAjaxController@fetchdata')->name('regionajax.fetchdata');
Route::get('regionajax/removedata','RegionAjaxController@removedata')->name('regionajax.removedata');
Route::get('regionajax/massremove','RegionAjaxController@massremove')->name('regionajax.massremove');

