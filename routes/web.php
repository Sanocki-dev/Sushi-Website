<?php

use App\Model;

Route::get('/', 'MenuController@index')->name('home');
Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');
Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');
Route::get('/menu', 'MenuController@menu');
Route::get('/orderMenu', 'MenuController@orderMenu')->name('menu.orderMenu');
Route::get('/orderSummary', 'MenuController@orderSummary')->name('checkout.summary');
Route::post('/orderSummary', 'MenuController@postCheckout');
Route::get('/orderStatus', 'MenuController@orderStatus');
// Route::get('/checkout', 'MenuController@getCheckout')->name('checkout');
// Route::post('/checkout', 'MenuController@postCheckout')->name('checkout');
Route::get('/history', 'MenuController@history');
Route::get('/forgotPassword', 'SessionsController@forgotPassword');
Route::get('/account', 'MenuController@account');
Route::post('/account', 'MenuController@store');
Route::get('/orderHistory', 'MenuController@show');
Route::post('/orderItems', 'MenuController@orderItems');
Route::get('/orderPayment', 'MenuController@orderPayment');
Route::post('/orderPayment', 'MenuController@orderPayment');

Route::get('/add-to-cart/{id}', 'MenuController@addToCart');

Route::delete('/remove-from-cart', 'MenuController@removeFromCart')->name('cart.destroy');
Route::delete('/remove-from-order', 'MenuController@removeFromOrder')->name('order.destroy');

Route::get('/editMenu', 'MenuController@editMenu');
Route::get('/editMenuItem/{menu_ID}', 'MenuController@editMenuItem');
Route::post('/editMenuItem/{menu_ID}', 'MenuController@saveEdit');
Route::get('/deleteMenuItem/{menu_ID}', 'MenuController@deleteItem');
Route::post('/editMenu', 'MenuController@addItem');

Route::get('/currentOrders', 'MenuController@currentOrders')->name('currentOrders');;
Route::get('/currentOrder/{id}', 'MenuController@currentOrder');
Route::post('/complete/{id}', 'MenuController@finishOrder');

Route::get('/salesReport', 'MenuController@salesReport');

Route::post('/promo', 'PromotionsController@store')->name('promo.store');
Route::delete('/promo', 'PromotionsController@destroy')->name('promo.destroy');

