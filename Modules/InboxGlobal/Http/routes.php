<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'inboxglobal', 'namespace' => 'Modules\InboxGlobal\Http\Controllers'], function () {
    Route::any('/', ['middleware' => 'feature_control:114', 'uses' => 'InboxGlobalController@inboxGlobalList']);
    Route::any('/page/{page}', ['middleware' => 'feature_control:114', 'uses' => 'InboxGlobalController@inboxGlobalList']);
    Route::any('create', ['middleware' => 'feature_control:116', 'uses' => 'InboxGlobalController@create']);
    Route::any('edit/{id}', ['middleware' => 'feature_control:115,117', 'uses' => 'InboxGlobalController@edit']);
    Route::any('delete/{id}', ['middleware' => 'feature_control:118', 'uses' => 'InboxGlobalController@delete']);
    Route::get('ajax', ['middleware' => 'feature_control:114', 'uses' => 'InboxGlobalController@indexAjax']);
});
