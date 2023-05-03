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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'achievement'], function () {
    Route::get('/', 'AchievementController@index');
    Route::post('/', 'AchievementController@indexAjax');
    Route::any('outlet/{id_province}', 'AchievementController@getOutlet');
    Route::any('create', 'AchievementController@create');
    Route::any('remove', 'AchievementController@remove');
    Route::any('detail/{slug}', 'AchievementController@show');
    Route::any('detailAjax', 'AchievementController@detailAjax');
    Route::any('update/detail', 'AchievementController@update');
    Route::any('update/achievement', 'AchievementController@updateAchievement');

    /*Report Achievement*/
    Route::any('report', 'ReportAchievementController@reportAchievement');
    Route::any('report/detail/{id}', 'ReportAchievementController@reportDetailAchievement');
    Route::any('report/list-user/{id}', 'ReportAchievementController@reportListUserAchievement');

    /*Report User Achievement*/
    Route::any('report/user-achievement', 'ReportAchievementController@reportUser');
    Route::any('report/user-achievement/detail/{phone}', 'ReportAchievementController@reportDetailUser');
    Route::any('report/user-achievement/detail-badge/{id_achievement_group}/{phone}', 'ReportAchievementController@reportDetailBadgeUser');

    /*Report Membership*/
    Route::any('report/membership', 'ReportAchievementController@reportMembership');
    Route::any('report/membership/detail-view/{id}', 'ReportAchievementController@reportDetailMembershipView');
    Route::any('report/membership/detail/{id}', 'ReportAchievementController@reportDetailMembership');
    Route::any('report/membership/list-user/{id}', 'ReportAchievementController@reportListUserMembership');
});
