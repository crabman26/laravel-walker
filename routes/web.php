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

//Handle basic page request
Route::get('index','CategoriesAjaxController@categories');
Route::get('ads/{keyword}','AdsAjaxController@adslist')->name('ads');
Route::get('about','MainController@about')->name('about');
Route::get('contact','MainController@contact')->name('contact');
Route::get('terms','MainController@terms')->name('terms');
Route::get('login','MainController@login')->name('login');

//Handle login request
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');

//Handle register request
Route::get('/register', 'EmailAvailable@index');
Route::post('/register/check', 'EmailAvailable@check')->name('register.check');

//Handle contact form request
Route::post('/contact/savecontact','ContactController@savecontact');
Route::get('/contactform','ContactController@viewcontacts');
Route::get('/contact/replyform/{Id}','ContactController@replyform');
Route::post('/contact/replymail/{Mail}','ContactController@replymail');

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
Route::get('categoriesajax/getcategories','CategoriesAjaxController@getcategories')->name('categoriesajax.getcategories');
Route::post('categoriesajax/fetchkeywords', 'CategoriesAjaxController@fetchkeywords')->name('categoriesajax.fetchkeywords');

Route::get('regionajax','RegionAjaxController@index')->name('regionajax');
Route::get('regionajax/getdata','RegionAjaxController@getdata')->name('regionajax.getdata');
Route::post('regionajax/postdata','RegionAjaxController@postdata')->name('regionajax.postdata');
Route::get('regionajax/fetchdata','RegionAjaxController@fetchdata')->name('regionajax.fetchdata');
Route::get('regionajax/removedata','RegionAjaxController@removedata')->name('regionajax.removedata');
Route::get('regionajax/massremove','RegionAjaxController@massremove')->name('regionajax.massremove');
Route::get('regionajax/getregionlist','RegionAjaxController@getregionlist')->name('regionajax.getregionlist');

Route::get('municipalityajax','MunicipalityAjaxController@index')->name('municipalityajax');
Route::get('municipalityajax/getdata','MunicipalityAjaxController@getdata')->name('municipalityajax.getdata');
Route::post('municipalityajax/postdata','MunicipalityAjaxController@postdata')->name('municipalityajax.postdata');
Route::get('municipalityajax/fetchdata','MunicipalityAjaxController@fetchdata')->name('municipalityajax.fetchdata');
Route::get('municipalityajax/removedata','MunicipalityAjaxController@removedata')->name('municipalityajax.removedata');
Route::get('municipalityajax/massremove','MunicipalityAjaxController@massremove')->name('municipalityajax.massremove');
Route::get('municipalityajax/getmunicipalities','MunicipalityAjaxController@getmunicipalities')->name('municipalityajax.getmunicipalities');
Route::get('municipalityajax/getregionmunicipality','MunicipalityAjaxController@getregionmunicipality')->name('municipalityajax.getregionmunicipality');
Route::post('municipalityajax/fetchmunicipalities', 'MunicipalityAjaxController@fetchmunicipalities')->name('municipalityajax.fetchmunicipalities');

Route::get('usersajax','UserAjaxController@index')->name('usersajax');
Route::get('usersajax/getdata','UserAjaxController@getdata')->name('usersajax.getdata');
Route::post('usersajax/postdata','UserAjaxController@postdata')->name('usersajax.postdata');
Route::get('usersajax/fetchdata','UserAjaxController@fetchdata')->name('usersajax.fetchdata');
Route::get('usersajax/removedata','UserAjaxController@removedata')->name('usersajax.removedata');
Route::get('usersajax/massremove','UserAjaxController@massremove')->name('usersajax.massremove');

Route::get('memberads','MainController@memberads')->name('memberads');
Route::get('memberprofile','MainController@memberprofile')->name('memberprofile');
Route::get('usersajax/memberdata','UserAjaxController@memberdata')->name('usersajax.memberdata');

Auth::routes(['verify' => true]); 

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/stats', 'GoogleGraphController@index')->name('home');
