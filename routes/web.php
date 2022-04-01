<?php

use App\Model;
// Index
Route::get('/', 'MenuController@index')->name('home');

// Account
Route::get('/admin', 'MenuController@change');
Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');
Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');
Route::get('/forgotPassword', 'SessionsController@forgotPassword');
Route::get('/account', 'MenuController@account');
Route::post('/account', 'MenuController@store');

// Orders
Route::get('/orderMenu', 'MenuController@orderMenu')->name('menu.orderMenu');
Route::get('/orderSummary', 'MenuController@orderSummary')->name('checkout.summary');
Route::post('/orderSummary', 'MenuController@postCheckout')->name('checkout.store');;
Route::get('/orderStatus', 'MenuController@orderStatus')->name('order.status');
Route::get('/orderHistory', 'MenuController@show');
Route::post('/orderItems', 'MenuController@orderItems');
Route::get('/history', 'MenuController@history');

// Cart
Route::get('/add-to-cart/{id}', 'MenuController@addToCart');
Route::delete('/remove-from-cart', 'MenuController@removeFromCart')->name('cart.destroy');
Route::delete('/remove-from-order', 'MenuController@removeFromOrder')->name('order.destroy');

// Menu
Route::get('/menu', 'MenuController@menu');
Route::get('/editMenu', 'MenuController@editMenu');
Route::get('/editMenuItem/{menu_ID}', 'MenuController@editMenuItem');
Route::post('/editMenuItem/{menu_ID}', 'MenuController@saveEdit');
Route::get('/deleteMenuItem/{menu_ID}', 'MenuController@deleteItem');
Route::post('/editMenu', 'MenuController@addItem');

// Current Orders
Route::get('/currentOrders', 'MenuController@currentOrders')->name('currentOrders');;
Route::get('/currentOrder/{id}', 'MenuController@currentOrder');

// Complete Order
Route::get('/pickup', 'MenuController@pickup')->name('pickup');;
Route::post('/complete/{id}', 'MenuController@finishOrder');
Route::get('/completeTransaction/{id}', 'MenuController@completeTransaction');

// Reports 
Route::get('/salesReport', 'MenuController@salesReport');
Route::get('/menuItemReport', 'MenuController@menuReport');
Route::get('/ingredientReport', 'MenuController@ingredientReport');

// Suppliers
Route::get('/suppliers', 'SuppliersController@index')->name('supplier.index');
Route::post('/createSupplier', 'SuppliersController@store')->name('supplier.store');
Route::delete('/deleteSupplier', 'SuppliersController@delete')->name('supplier.delete');
Route::get('/supplier/{id}', 'SuppliersController@find');

Route::get('/ingredients', 'IngredientsController@index')->name('ingredient.index');
Route::post('/ingredients', 'IngredientsController@store')->name('ingredient.store');
Route::delete('/ingredients', 'IngredientsController@delete')->name('ingredient.delete');

Route::post('/promo', 'PromotionsController@store')->name('promo.store');
Route::delete('/promo', 'PromotionsController@destroy')->name('promo.destroy');

