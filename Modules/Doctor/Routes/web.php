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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'doctor'], function () {
    Route::get('/', 'DoctorController@index');
    Route::post('/', 'DoctorController@filter');
    Route::any('/create', 'DoctorController@create');
    Route::get('/{id}/show', 'DoctorController@show');
    Route::post('/store', 'DoctorController@store');
    Route::get('/{id}/edit', 'DoctorController@edit');
    Route::put('/{id}/update', 'DoctorController@update');
    Route::put('/{id}/update-password', 'DoctorController@updatePassword');
    Route::put('/{id}/update-schedule', 'DoctorController@updateSchedule');
    Route::post('/delete', 'DoctorController@destroy');

    Route::resource('service', 'DoctorServiceController');
    Route::resource('specialist', 'DoctorSpecialistController');
    Route::resource('specialist-category', 'DoctorSpecialistCategoryController');

    Route::any('autoresponse/{subject}', ['middleware' => 'feature_control:93', 'uses' => 'DoctorController@autoResponse']);
    Route::any('recommendation', ['uses' => 'DoctorController@doctorRecommendation']);

    Route::group(['prefix' => 'update-data'], function () {
        Route::any('/', ['middleware' => 'feature_control:356,357,358', 'uses' => 'DoctorUpdateDataController@list']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:357,358', 'uses' => 'DoctorUpdateDataController@detail']);
        Route::post('update/{id}', ['middleware' => 'feature_control:358', 'uses' => 'DoctorUpdateDataController@update']);
    });
});
