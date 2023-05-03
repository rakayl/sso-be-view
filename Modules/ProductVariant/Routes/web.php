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

Route::prefix('product-variant')->group(function () {
    Route::group(['middleware' => 'validate_session'], function () {
        Route::get('/', ['middleware' => 'feature_control:278', 'uses' => 'ProductVariantController@index']);
        Route::get('position', ['middleware' => 'feature_control:278', 'uses' => 'ProductVariantController@position']);
        Route::post('position', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantController@position']);
        Route::get('create', ['middleware' => 'feature_control:279', 'uses' => 'ProductVariantController@create']);
        Route::post('store', ['middleware' => 'feature_control:279', 'uses' => 'ProductVariantController@store']);
        Route::get('edit/{id}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantController@edit']);
        Route::post('update/{id}', ['middleware' => 'feature_control:281', 'uses' => 'ProductVariantController@update']);
        Route::any('delete/{id}', ['middleware' => 'feature_control:282', 'uses' => 'ProductVariantController@destroy']);
        Route::post('export', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantController@export']);
        Route::get('import', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantController@import']);
        Route::post('import/save', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantController@importSave']);
    });
});

Route::prefix('product-variant-group')->group(function () {
    Route::group(['middleware' => 'validate_session'], function () {
        Route::any('list', ['uses' => 'ProductVariantGroupController@listProduct']);
        Route::any('ajax/{idProduct}', ['uses' => 'ProductVariantGroupController@ajaxProductvariantGroup']);
        Route::any('edit/{product_code}', ['uses' => 'ProductVariantGroupController@editProductVariant']);
        Route::any('delete/{product_code}', ['uses' => 'ProductVariantGroupController@deleteProductVariant']);

        Route::get('price/{id_outlet?}', ['middleware' => 'feature_control:279,281', 'uses' => 'ProductVariantGroupController@listPrice']);
        Route::post('price/{id_outlet}', ['middleware' => 'feature_control:279,281', 'uses' => 'ProductVariantGroupController@updatePrice']);
        Route::get('detail/{id_outlet?}', ['middleware' => 'feature_control:279,281', 'uses' => 'ProductVariantGroupController@listDetail']);
        Route::post('detail/{id_outlet}', ['middleware' => 'feature_control:279,281', 'uses' => 'ProductVariantGroupController@updateDetail']);
        Route::post('export', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@export']);
        Route::get('import', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@import']);
        Route::post('import/save', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@importSave']);

        Route::post('export-price', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@exportPrice']);
        Route::get('import-price', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@importPrice']);
        Route::post('import-price/save', ['middleware' => ['feature_control:279,281'], 'uses' => 'ProductVariantGroupController@importPriceSave']);

        Route::any('list-group', ['uses' => 'ProductVariantGroupController@listProductVariant']);
        Route::post('remove', ['uses' => 'ProductVariantGroupController@removeProductVariant']);
    });
});
