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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//products routes
Route::prefix('products')->group(function () {
    Route::get('/',              'ProductController@index' )->name('ProductsShowAll');
    Route::get('{product}',      'ProductController@show'  )->name('ProductsShowOne')->where(['product' => '[0-9]+']);
    Route::get('/create',         'ProductController@create')->name('ProductsShowOne_FormCreate');
    Route::get('{product}/edit', 'ProductController@edit'  )->name('ProductsShowOne_FormEdit');

    Route::middleware(['auth'])->group(function () {
        Route::post('/', 'ProductController@store')->name('ProductsAddOne');
        Route::patch('/{product}', 'ProductController@update')->name('ProductsEditOne')->where(['product' => '[0-9]+']);
        Route::delete('/{product}', 'ProductController@destroy')->name('ProductsRemoveOne')->where(['product' => '[0-9]+']);
    });    
});

//products routes
Route::prefix('cart')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/',                'CartController@index'      )->name('CartShowAll');
        Route::post('/',               'CartController@store'      )->name('CartAddProducts');
        Route::patch('/{product}',     'CartController@update'     )->name('CartAddProducts')->where(['product' => '[0-9]+']);
        Route::delete('/{product}',    'CartController@destroy'    )->name('CartRemoveProducts')->where(['product' => '[0-9]+']);
        Route::delete('/',             'CartController@destroyMany')->name('CartRemoveProducts');
    });    
});

//products routes
Route::prefix('order')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/',                'OrderController@index'  )->name('OrderShowAll');
        Route::post('/',               'OrderController@store'  )->name('OrderFromCart');
    });    
});
