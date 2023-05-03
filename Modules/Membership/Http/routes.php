<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'membership', 'namespace' => 'Modules\Membership\Http\Controllers'], function () {
    Route::any('/', ['middleware' => ['feature_control:11', 'config_control:20'], 'uses' => 'MembershipController@membershipList']);
    Route::get('create', ['middleware' => ['feature_control:11', 'config_control:20'], 'uses' => 'MembershipController@create']);
    Route::post('create', ['middleware' => ['feature_control:13', 'config_control:20'], 'uses' => 'MembershipController@create']);
    // Route::get('update/{id}', ['middleware' => ['feature_control:13', 'config_control:20'], 'uses' => 'MembershipController@update']);
 //    Route::post('update/{id}', ['middleware' => ['feature_control:13', 'config_control:20'], 'uses' => 'MembershipController@update']);
    // Route::get('delete/{id}', ['middleware' => ['feature_control:14', 'config_control:20'], 'uses' => 'MembershipController@delete']);
});

// Route::group([ 'prefix' => 'membership', 'namespace' => 'Modules\Membership\Http\Controllers'], function()
// {
//     Route::any('/web/view', 'MembershipController@detailWebview');
// });
