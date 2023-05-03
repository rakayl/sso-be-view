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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product-bundling'], function () {
    /**
     * Bundling
     */
    Route::any('/', 'ProductBundlingController@index');
    Route::get('create', 'ProductBundlingController@create');
    Route::post('store', 'ProductBundlingController@store');
    Route::get('detail/{id}', 'ProductBundlingController@detail');
    Route::post('update/{id}', 'ProductBundlingController@update');
    Route::post('product-brand', 'ProductBundlingController@productBrand');
    Route::post('outlet-available', 'ProductBundlingController@outletAvailable');
    Route::post('global-price', 'ProductBundlingController@getGlobalPrice');
    Route::post('delete', 'ProductBundlingController@destroy');
    Route::post('delete-product', 'ProductBundlingController@destroyBundlingProduct');
    Route::get('position/assign', 'ProductBundlingController@positionAssign');
    Route::post('position/assign', 'ProductBundlingController@updatePositionAssign');

    //Product Bundling Category
    Route::get('category', 'BundlingCategoryController@indexBundlingCategory');
    Route::get('category/create', 'BundlingCategoryController@createBundlingCategory');
    Route::post('category/store', 'BundlingCategoryController@storeBundlingCategory');
    Route::any('category/edit/{id}', 'BundlingCategoryController@updateBundlingCategory');
    Route::any('category/delete', 'BundlingCategoryController@deleteBundlingCategory');
    Route::post('category/position/assign', 'BundlingCategoryController@positionCategoryAssign');

    //setting name brand
    Route::any('setting', 'ProductBundlingController@settings');
});
