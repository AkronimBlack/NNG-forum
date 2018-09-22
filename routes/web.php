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



Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads/create' , 'ThreadsController@create');
Route::get('/threads' , 'ThreadsController@index');
Route::get('/threads/{channel}' , 'ThreadsController@index');
Route::get('/threads/{channel}/{thread} ' , 'ThreadsController@show');
Route::DELETE('/threads/{channel}/{thread} ' , 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/subscriptions' , 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions' , 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/threads' , 'ThreadsController@store');
Route::post('/threads/{channel}/{thread}/replies' , 'RepliesController@store');

Route::get('/threads/{channel}/{thread}/replies' , 'RepliesController@index');

Route::DELETE('/replies/{reply}' , 'RepliesController@destroy');
Route::PATCH('/replies/{reply}' , 'RepliesController@update');

Route::post('/replies/{reply}/favorite' , 'FavoritesController@store');
Route::DELETE('/replies/{reply}/favorite' , 'FavoritesController@destroy');

Route::get('/profiles/{user}' , 'ProfilesController@show')->name('profile');

Route::DELETE('/profiles/{user}/notifications/{notification}' , 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications' , 'UserNotificationsController@index');

//remake the rout bs



