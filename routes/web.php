<?php

use App\Model;

Route::get('/', 'MenuController@index')->name('home');
Route::get('/about', 'MenuController@about');
Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');
Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');
Route::get('/menu', 'MenuController@menu');
Route::get('/orderMenu', 'MenuController@orderMenu');
Route::post('/orderSummary', 'MenuController@orderSummary');
Route::get('/history', 'MenuController@history');
Route::get('/forgotPassword', 'SessionsController@forgotPassword');
Route::get('/account', 'MenuController@account');
Route::post('/account', 'MenuController@store');
Route::get('/orderHistory', 'MenuController@show');
Route::post('/orderItems', 'MenuController@orderItems');
Route::get('/orderPayment', 'MenuController@orderPayment');
Route::post('/orderPayment', 'MenuController@orderPayment');

Route::get('/editMenu', 'MenuController@editMenu');
Route::get('/currentOrders', 'MenuController@currentOrders');
Route::get('/salesReport', 'MenuController@salesReport');


