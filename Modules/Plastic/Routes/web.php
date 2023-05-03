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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'plastic-type'], function () {
    Route::get('/', ['middleware' => 'feature_control:48,49,51', 'uses' => 'PlasticTypeController@index']);
    Route::get('create', ['middleware' => 'feature_control:50', 'uses' => 'PlasticTypeController@create']);
    Route::post('store', ['middleware' => 'feature_control:50', 'uses' => 'PlasticTypeController@store']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:49,51', 'uses' => 'PlasticTypeController@detail']);
    Route::post('update/{id}', ['middleware' => 'feature_control:51', 'uses' => 'PlasticTypeController@update']);
    Route::post('delete', ['middleware' => 'feature_control:52', 'uses' => 'PlasticTypeController@destroy']);
    Route::any('position', ['middleware' => 'feature_control:51', 'uses' => 'PlasticTypeController@position']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product-plastic'], function () {
    Route::get('/', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@index']);
    Route::any('stock-outlet/{key?}', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@productPlasticStockOutlet']);
    Route::get('create', ['middleware' => 'feature_control:50', 'uses' => 'ProductPlasticController@create']);
    Route::post('store', ['middleware' => 'feature_control:50', 'uses' => 'ProductPlasticController@store']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:49,51', 'uses' => 'ProductPlasticController@detail']);
    Route::post('update/{id}', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@update']);
    Route::post('delete', ['middleware' => 'feature_control:52', 'uses' => 'ProductPlasticController@destroy']);
    Route::post('visibility', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@visibility']);

    Route::get('import', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@importUsePlastic']);
    Route::post('import/save', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@imporSavetUsePlastic']);
    Route::post('export', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@exportUsePlastic']);

    Route::get('import-product-variant', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@imporProductVariantUsePlastic']);
    Route::post('import-product-variant/save', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@imporProductVariantSavetUsePlastic']);
    Route::post('export-product-variant', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@exportProductVariantUsePlastic']);

    Route::get('import-price', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@importPlasticPrice']);
    Route::post('import-price/save', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@imporSavePlasticPrice']);
    Route::post('export-price', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@exportPlasticPrice']);

    Route::get('import-plastic-status-outlet', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@importPlasticStatusOutlet']);
    Route::post('import-plastic-status-outlet/save', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@importSavePlasticStatusOutlet']);
    Route::post('export-plastic-status-outlet', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@exportPlasticStatusOutlet']);

    Route::get('use/product', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@usePlastiProduct']);
    Route::post('use/product', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@usePlastiProduct']);
    Route::get('use/product-variant', ['middleware' => 'feature_control:48,49,51', 'uses' => 'ProductPlasticController@usePlastiProductVariant']);
    Route::post('use/product-variant', ['middleware' => 'feature_control:51', 'uses' => 'ProductPlasticController@usePlastiProductVariant']);
});
