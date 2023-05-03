<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'point-injection', 'namespace' => 'Modules\PointInjection\Http\Controllers'], function () {
    Route::any('/', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@index']);
    Route::get('create', ['middleware' => 'feature_control:207', 'uses' => 'PointInjectionController@create']);
    Route::post('create', ['middleware' => 'feature_control:207', 'uses' => 'PointInjectionController@store']);
    Route::get('review/{id_point_injection}', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@review']);
    Route::get('edit/{id_point_injection}', ['middleware' => 'feature_control:206,208', 'uses' => 'PointInjectionController@show']);
    Route::post('edit/{id_point_injection}', ['middleware' => 'feature_control:208', 'uses' => 'PointInjectionController@update']);
    Route::get('delete/{id_point_injection}', ['middleware' => 'feature_control:209', 'uses' => 'PointInjectionController@destroy']);
    Route::post('edit/{id_point_injection}/page/{page}', ['middleware' => 'feature_control:206,208', 'uses' => 'PointInjectionController@update']);
    Route::any('/page/{page}', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@index']);
    Route::any('/review/{id_point_injection}/page/{page}', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@review']);
    Route::get('/edit/{id_point_injection}/page/{page}', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@show']);
    Route::any('/report/{id_point_injection}', ['middleware' => 'feature_control:205,206', 'uses' => 'PointInjectionController@report']);
});
