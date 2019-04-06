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
    Route::get('{product}',      'ProductController@show'  )->name('ProductsShowOne');
    Route::get('/create',         'ProductController@create')->name('ProductsShowOne_FormCreate');
    Route::get('{product}/edit', 'ProductController@edit'  )->name('ProductsShowOne_FormEdit');

    Route::middleware(['auth'])->group(function () {
        Route::post('/', 'ProductController@store')->name('ProductsAddOne');
        Route::patch('/{id}', 'ProductController@update')->name('ProductsEditOne');
        Route::delete('/{id}', 'ProductController@destroy')->name('ProductsRemoveOne');
    });    
});
