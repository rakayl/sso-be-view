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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'payment-method'], function () {
    Route::get('/', 'PaymentMethodController@index');
    Route::get('create', 'PaymentMethodController@create');
    Route::post('store', 'PaymentMethodController@store');
    Route::get('edit/{id}', 'PaymentMethodController@edit');
    Route::post('update/{id}', 'PaymentMethodController@update');
    Route::get('delete/{id}', 'PaymentMethodController@destroy');
    Route::get('detail/{id}', 'PaymentMethodController@differentPaymentMethod');
    Route::post('detail/list/{id}', 'PaymentMethodController@getDifferentPaymentMethod');
    Route::post('detail/update', 'PaymentMethodController@updateDifferentPaymentMethod');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'payment-method-category'], function () {
    Route::get('/', 'PaymentMethodCategoryController@index');
    Route::get('create', 'PaymentMethodCategoryController@create');
    Route::post('store', 'PaymentMethodCategoryController@store');
    Route::get('edit/{id}', 'PaymentMethodCategoryController@edit');
    Route::post('update/{id}', 'PaymentMethodCategoryController@update');
    Route::get('delete/{id}', 'PaymentMethodCategoryController@destroy');
});
