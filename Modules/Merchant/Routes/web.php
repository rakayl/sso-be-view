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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'merchant'], function () {
    Route::get('setting/register-introduction', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterIntroduction']);
    Route::post('setting/register-introduction', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterIntroduction']);
    Route::get('setting/register-success', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterSuccess']);
    Route::post('setting/register-success', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterSuccess']);
    Route::get('setting/register-approved', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterApproved']);
    Route::post('setting/register-approved', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterApproved']);
    Route::get('setting/register-rejected', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterRejected']);
    Route::post('setting/register-rejected', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterRejected']);


    //withdrawl
    Route::get('withdrawal', 'MerchantController@withdrawalList');
    Route::post('withdrawal', 'MerchantController@withdrawalList');
    Route::post('withdrawal/completed', 'MerchantController@withdrawalCompleted');

});
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'tukang-sedot'], function () {
 
    //commission
    Route::group(['prefix' => '/commission'], function () {
        Route::any('/', 'CommissionController@listCommission');
        Route::get('create', 'CommissionController@createCommission');
        Route::post('store', 'CommissionController@storeCommission');
        Route::get('detail/{id}', 'CommissionController@detailCommission');
        Route::post('update/{id}', 'CommissionController@updateCommission');
     });
      //merchant management
    Route::any('/', 'MerchantController@list');
    Route::get('create', 'MerchantController@create');
    Route::post('store', 'MerchantController@store');
    Route::get('detail/{id}', 'MerchantController@detail');
    Route::post('update/{id}', 'MerchantController@update');
    Route::post('grading/{id}', 'MerchantController@updateGrading');
    Route::any('candidate', 'MerchantController@candidate');
    Route::get('candidate/detail/{id}', 'MerchantController@detail');
    Route::post('candidate/update/{id}', 'MerchantController@candidateUpdate');
    Route::post('candidate/delete/{id}', 'MerchantController@candidateDelete');

});
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'kontraktor'], function () {
    //commission
      //merchant management
    Route::any('/', 'KontraktorController@list');
    Route::get('create', 'KontraktorController@create');
    Route::post('store', 'KontraktorController@store');
    Route::get('detail/{id}', 'KontraktorController@detail');
    Route::post('update/{id}', 'KontraktorController@update');
    Route::post('grading/{id}', 'KontraktorController@updateGrading');
    Route::any('candidate', 'KontraktorController@candidate');
    Route::get('candidate/detail/{id}', 'KontraktorController@detail');
    Route::post('candidate/update/{id}', 'KontraktorController@candidateUpdate');
    Route::post('candidate/delete/{id}', 'KontraktorController@candidateDelete');
    Route::group(['prefix' => '/commission'], function () {
        Route::any('/', 'CommissionSurveyController@listCommission');
        Route::get('create', 'CommissionSurveyController@createCommission');
        Route::post('store', 'CommissionSurveyController@storeCommission');
        Route::get('detail/{id}', 'CommissionSurveyController@detailCommission');
        Route::post('update/{id}', 'CommissionSurveyController@updateCommission');
     });

});
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'event'], function () {
    Route::any('/', 'EventController@list');
    Route::get('create', 'EventController@create');
    Route::post('store', 'EventController@store');
    Route::get('detail/{id}', 'EventController@detail');
    Route::get('delete/{id}', 'EventController@delete');
    Route::post('update/{id}', 'EventController@update');
});
