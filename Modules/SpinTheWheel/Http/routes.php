<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'spinthewheel', 'namespace' => 'Modules\SpinTheWheel\Http\Controllers'], function () {
    Route::get('/list', ['middleware' => 'feature_control:130', 'uses' => 'SpinTheWheelController@list']);
    Route::any('/create', ['middleware' => 'feature_control:131', 'uses' => 'SpinTheWheelController@create']);
    Route::get('/edit/{slug}', ['middleware' => 'feature_control:132', 'uses' => 'SpinTheWheelController@edit']);
    Route::post('/edit', ['middleware' => 'feature_control:132', 'uses' => 'SpinTheWheelController@update']);
    Route::any('/delete', ['middleware' => 'feature_control:133', 'uses' => 'SpinTheWheelController@destroy']);
    Route::any('/setting', ['middleware' => 'feature_control:134', 'uses' => 'SpinTheWheelController@setting']);
});

/* Webview */
Route::group(['middleware' => 'web', 'prefix' => 'webview/spin-the-wheel', 'namespace' => 'Modules\SpinTheWheel\Http\Controllers'], function () {
    Route::get('/', 'WebviewSpinTheWheelController@index');
    // ajax for claim spin prize
    Route::get('/spin', 'WebviewSpinTheWheelController@spin');
});
