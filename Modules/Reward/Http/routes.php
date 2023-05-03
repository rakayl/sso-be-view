<?php

Route::group(['middleware' => ['web', 'validate_session','config_control:73'], 'prefix' => 'reward', 'namespace' => 'Modules\Reward\Http\Controllers'], function () {
    Route::get('/', ['middleware' => 'feature_control:130,131', 'uses' => 'RewardController@list']);
    Route::any('/create', ['middleware' => 'feature_control:132', 'uses' => 'RewardController@create']);
    Route::any('/detail/{slug}', ['middleware' => 'feature_control:131,133', 'uses' => 'RewardController@detail']);
    Route::post('/delete', ['middleware' => 'feature_control:134', 'uses' => 'RewardController@delete']);
    Route::post('/winner', ['middleware' => 'feature_control:133', 'uses' => 'RewardController@setWinner']);
});
