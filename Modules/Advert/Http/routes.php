<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'advert', 'namespace' => 'Modules\Advert\Http\Controllers'], function () {
    Route::any('{key}', ['middleware' => 'feature_control:124', 'uses' => 'AdvertController@index']);
});
Route::group(['middleware' => ['web', 'validate_session'], 'namespace' => 'Modules\Advert\Http\Controllers'], function () {
    Route::any('advert-delete', ['middleware' => 'feature_control:124', 'uses' => 'AdvertController@delete']);
});
