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

Route::group(['middleware' => ['web', 'validate_session', 'config_control:84'], 'prefix' => 'subscription'], function () {
    Route::get('/', 'SubscriptionController@index');
    Route::any('create', 'SubscriptionController@create');
    Route::any('step1/{slug}', 'SubscriptionController@create');
    Route::any('step1', 'SubscriptionController@create');
    Route::any('step2/{slug}', 'SubscriptionController@step2');
    Route::any('step3/{slug}', 'SubscriptionController@step3');
    // Route::any('detail/{slug}', 'SubscriptionController@detail');
    // Route::any('detail/{slug}/{subs_receipt}', 'SubscriptionController@transaction');
    Route::any('detail/{slug}', 'SubscriptionController@detailv2');
    Route::any('detail/{slug}/{subs_receipt}', 'SubscriptionController@transaction');
    Route::any('participate-ajax', 'SubscriptionController@participateAjax');
    Route::any('delete', 'SubscriptionController@deleteSubscription');

    Route::any('list-ajax', 'SubscriptionController@listSubcriptionAjax');
    Route::post('update-complete', ['uses' => 'SubscriptionController@updateComplete']);

    /* Report */
    Route::any('claim-report', ['uses' => 'SubscriptionController@report', 'report_type' => 'claim']);
    Route::any('transaction-report', ['uses' => 'SubscriptionController@report', 'report_type' => 'transaction']);
    Route::any('list-export', [ 'uses' => 'SubscriptionController@listExport']);
    Route::any('export-action/{action}/{id}', [ 'uses' => 'SubscriptionController@actionExport']);
});

Route::group(['middleware' => ['web', 'validate_session', 'config_control:84'], 'prefix' => 'welcome-subscription', 'subscription_type' => 'welcome'], function () {
    Route::any('/', ['middleware' => 'feature_control:264', 'uses' => 'SubscriptionController@index'])->defaults('subs_type', 'welcome');
    Route::any('create', ['middleware' => 'feature_control:266', 'uses' => 'SubscriptionController@create']);
    Route::any('step1/{id}', ['middleware' => 'feature_control:267', 'uses' => 'SubscriptionController@create']);
    Route::any('step2/{id}', ['middleware' => 'feature_control:267', 'uses' => 'SubscriptionController@step2']);
    Route::any('step3/{id}', ['middleware' => 'feature_control:267', 'uses' => 'SubscriptionController@step3']);
    Route::post('update-complete', ['middleware' => 'feature_control:267', 'uses' => 'SubscriptionController@updateComplete']);
    Route::any('detail/{id}', ['middleware' => 'feature_control:265', 'uses' => 'SubscriptionController@detailv2']);
    Route::any('update', ['middleware' => 'feature_control:267', 'uses' => 'SubscriptionController@updateReq']);
    Route::any('setting', 'SubscriptionController@welcomeSubscriptionSetting');
    Route::any('update/status', 'SubscriptionController@welcomeSubscriptionUpdateStatus');
});
