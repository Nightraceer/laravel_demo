<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'MainController@home')->name('home');


Route::get('/products', 'ProductsController@index')->name('products');

Route::get('/products/add', 'ProductsController@form')->name('products-form');

Route::post('/products/add', 'ProductsController@add')->name('products-add');


Route::get('/cart', 'CartController@index')->name('cart');

Route::get('/cart/toggle/{id}', 'CartController@toggle')->name('cart-toggle');

Route::get('/cart/inc/{position}', 'CartController@inc')->name('cart-inc');

Route::get('/cart/dec/{position}', 'CartController@dec')->name('cart-dec');

Route::get('/cart/remove/{position}', 'CartController@remove')->name('cart-remove');