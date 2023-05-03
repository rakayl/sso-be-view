<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'enquiries', 'namespace' => 'Modules\Enquiries\Http\Controllers'], function () {
    Route::any('/', ['middleware' => ['feature_control:83', 'config_control:56'], 'uses' => 'EnquiriesController@index']);
    Route::post('update', ['middleware' => 'feature_control:84', 'uses' => 'EnquiriesController@update']);
    Route::post('delete', ['middleware' => 'feature_control:84', 'uses' => 'EnquiriesController@delete']);
    Route::post('reply', ['middleware' => ['config_control:84'], 'uses' => 'EnquiriesController@reply']);
    Route::any('ajax', ['middleware' => ['feature_control:83', 'config_control:56'], 'uses' => 'EnquiriesController@indexAjax']);
    Route::get('detail/ajax', ['middleware' => 'feature_control:84', 'uses' => 'EnquiriesController@indexDetailAjax']);
});
