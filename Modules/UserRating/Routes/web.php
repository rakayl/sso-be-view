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

Route::prefix('user-rating')->middleware(['web', 'validate_session'])->group(function () {
    Route::post('option', 'RatingOptionController@store');
    Route::get('/detail/{id}', 'UserRatingController@show');
    Route::get('/', 'UserRatingController@index');
    Route::post('/', 'UserRatingController@setFilter');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
    Route::any('autoresponse/{target}', 'UserRatingController@autoresponse');
    Route::any('autoresponse', 'UserRatingController@autoresponse');
    Route::group(['prefix' => 'report'], function () {
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'UserRatingController@reportProduct');
            Route::post('/', 'UserRatingController@setReportFilterProduct');
            Route::get('detail', 'UserRatingController@reportListProduct');
            Route::get('detail/{id_product}', 'UserRatingController@reportDetailProduct');
        });

        Route::group(['prefix' => 'doctor'], function () {
            Route::get('/', 'UserRatingController@reportDoctor');
            Route::post('/', 'UserRatingController@setReportFilterDoctor');
            Route::get('detail', 'UserRatingController@reportListDoctor');
            Route::get('detail/{id_doctor}', 'UserRatingController@reportDetailDoctor');
        });

        Route::group(['prefix' => 'outlet'], function () {
            Route::get('detail/{id_outlet}', 'UserRatingController@reportProduct');
            Route::post('detail/{id_outlet}', 'UserRatingController@setReportFilterProduct');
            Route::get('/', 'UserRatingController@reportOutlet');
            Route::post('/', 'UserRatingController@reportOutlet');
        });
    });
});
