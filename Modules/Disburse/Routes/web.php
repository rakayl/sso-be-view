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
Route::get('/disburse', function () {
    return redirect('disburse/login');
});

Route::get('disburse/logout', function () {
    $a = session('success')['s'];
    session()->flush();
    if ($a) {
        session(['success' => ['s' => $a]]);
    }
    return redirect('disburse/login');
});

Route::group(['middleware' => 'web', 'prefix' => 'disburse'], function () {
    Route::get('login', function () {
        if (!session()->has('username-franchise')) {
            return view('disburse::login');
        } else {
            return redirect('disburse/home');
        }
    });

    Route::post('login', 'DisburseController@loginUserFranchise');

    Route::group(['middleware' => 'validate_session_disburse'], function () {
        Route::any('user-franchise/dashboard', 'DisburseController@dashboard');
        Route::post('user-franchise/getOutlets', 'DisburseController@getOutlets');
        Route::post('user-franchise/getUserFranchise', 'DisburseController@userFranchise');

        //Disburse
        Route::any('user-franchise/list/trx', 'DisburseController@listTrx');
        Route::any('user-franchise/list/{status}', 'DisburseController@listDisburse');
        Route::any('user-franchise/list-datatable/{status}', 'DisburseController@listDisburseDataTable');
        Route::any('user-franchise/detail-trx/{id}', 'DisburseController@detailDisburseTrx');
        Route::any('user-franchise/detail/{id}', 'DisburseController@detailDisburse');

        Route::any('user-franchise/reset-password', 'DisburseController@resetPassword');
    });

    Route::group(['middleware' => 'validate_session'], function () {
        Route::any('dashboard', 'DisburseController@dashboard');
        Route::post('getOutlets', 'DisburseController@getOutlets');
        Route::post('getUserFranchise', 'DisburseController@userFranchise');

        //Setting
        Route::any('setting/delete-bank-account', 'DisburseSettingController@deleteBankAccount');
        Route::any('setting/edit-bank-account', 'DisburseSettingController@editBankAccount');
        Route::any('setting/bank-account', 'DisburseSettingController@bankAccount');
        Route::any('setting/bank-account-update', 'DisburseSettingController@bankAccountUpdate');
        Route::any('setting/mdr', 'DisburseSettingController@mdr');
        Route::any('setting/mdr-global', 'DisburseSettingController@mdrGlobal');
        Route::get('setting/global', 'DisburseSettingController@settingGlobal');
        Route::post('setting/fee-global', 'DisburseSettingController@feeGlobal');
        Route::post('setting/point-charged-global', 'DisburseSettingController@pointChargedGlobal');
        Route::any('setting/fee-outlet-special/outlets', 'DisburseSettingController@listOutletAjax');
        Route::any('setting/fee-outlet-special/update', 'DisburseSettingController@settingFeeOutletSpecial');
        Route::any('setting/outlet-special', 'DisburseSettingController@settingSpecialOutlet');
        Route::any('setting/approver', 'DisburseSettingController@settingApprover');
        Route::any('setting/fee-product-plastic', 'DisburseSettingController@settingFeeProductPlastic');
        Route::any('setting/time-to-sent', 'DisburseSettingController@settingTimeToSent');
        Route::any('setting/fee-disburse', 'DisburseSettingController@settingFeeDisburse');
        Route::any('setting/send-email-to', 'DisburseSettingController@settingSendEmailTo');
        Route::any('setting/export-list-bank', 'DisburseSettingController@exportListBank');
        Route::any('setting/export-bank-account-outlet', 'DisburseSettingController@exportBankAccoutOutlet');
        Route::post('setting/import-bank-account-outlet', 'DisburseSettingController@importBankAccoutOutlet');
        Route::any('autoresponse/{subject}', 'DisburseSettingController@autoResponse');

        //Disburse
        Route::any('list/trx', 'DisburseController@listTrx');
        Route::any('list/fail-action', 'DisburseController@listDisburseFailAction');
        Route::any('list/{status}/{id_disburse??}', 'DisburseController@listDisburse');
        Route::any('list-datatable/calculation', 'DisburseController@listCalculationDataTable');
        Route::any('detail-trx/{id}', 'DisburseController@detailDisburseTrx');
        Route::any('update-status/{id}', 'DisburseController@updateStatusDisburse');

        Route::group(['prefix' => 'rule-promo-payment-gateway'], function () {
            Route::any('/', 'RulePromoPaymentGatewayController@index');
            Route::get('create', 'RulePromoPaymentGatewayController@create');
            Route::post('store', 'RulePromoPaymentGatewayController@store');
            Route::get('detail/{id}', 'RulePromoPaymentGatewayController@detail');
            Route::post('update/{id}', 'RulePromoPaymentGatewayController@update');
            Route::post('delete', 'RulePromoPaymentGatewayController@delete');
            Route::post('start', 'RulePromoPaymentGatewayController@start');
            Route::post('mark-as-valid', 'RulePromoPaymentGatewayController@markAsValid');
            Route::any('report/{id}', 'RulePromoPaymentGatewayController@reportListTransaction');

            Route::any('validation', 'RulePromoPaymentGatewayController@validation');
            Route::get('validation/template', 'RulePromoPaymentGatewayController@validationTemplate');
            Route::any('validation/report', 'RulePromoPaymentGatewayController@validationReport');
            Route::get('validation/report/detail/{id}', 'RulePromoPaymentGatewayController@validationReportDetail');
            Route::get('validation/report/download/{id}', 'RulePromoPaymentGatewayController@downloadFile');

            Route::any('list-trx', 'RulePromoPaymentGatewayController@promoPaymentGatewayListTransaction');
        });
    });
});
