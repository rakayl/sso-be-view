<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function () {
    Route::get('/setting/cashback', 'TransactionSettingController@list');
    Route::post('/setting/cashback/update', 'TransactionSettingController@update');
    Route::get('/setting/cashback-calculation', 'TransactionSettingController@cashbackCalculation');
    Route::post('/setting/cashback-calculation', 'TransactionSettingController@cashbackCalculationUpdate');
    Route::any('/setting/free-delivery', 'TransactionController@freeDelivery');
    Route::any('/setting/go-send-package-detail', 'TransactionController@goSendPackageDetail');
    Route::get('/setting/available-payment', 'TransactionController@availablePayment');
    Route::post('/setting/available-payment', 'TransactionController@availablePaymentUpdate');
    Route::get('/setting/refund-reject-order', 'TransactionSettingController@refundRejectOrder');
    Route::post('/setting/refund-reject-order', 'TransactionSettingController@updateRefundRejectOrder');
    Route::get('/setting/forward-why-low-balance', 'TransactionSettingController@forwardWeHelpYouLowBalance');
    Route::post('/setting/forward-why-low-balance', 'TransactionSettingController@updateForwardWeHelpYouLowBalance');
    Route::get('/setting/auto-reject', ['middleware' => 'feature_control:262', 'uses' => 'TransactionSettingController@autoReject']);
    Route::post('/setting/auto-reject', ['middleware' => 'feature_control:262', 'uses' => 'TransactionSettingController@updateAutoReject']);
    Route::any('/setting/timer-payment-gateway', 'TransactionController@timerPaymentGateway');
    Route::get('/setting/transaction-messages', 'TransactionSettingController@updateTransactionMessages');
    Route::post('/setting/transaction-messages', 'TransactionSettingController@updateTransactionMessages');
    Route::get('/setting/all-fee', 'TransactionSettingController@settingAllFee');
    Route::post('/setting/fee/{type}', 'TransactionSettingController@settingAllFee');

    //===== setting delivery =====//
    Route::get('/setting/available-delivery', 'TransactionController@availableDelivery');
    Route::post('/setting/available-delivery', 'TransactionController@availableDeliveryUpdate');
    Route::get('/setting/delivery-upload-image', 'TransactionController@deliveryUploadImage');
    Route::post('/setting/delivery-upload-image/save', 'TransactionController@deliveryUploadImage');
    Route::get('/setting/delivery-outlet', 'TransactionController@deliveryOutlet');
    Route::any('/setting/delivery-outlet/detail/{code}', 'TransactionController@deliveryOutletDetail');
    Route::post('/setting/delivery-outlet/all/{code}', 'TransactionController@deliveryOutletUpdateAll');
    Route::get('/setting/delivery-outlet/import', 'TransactionController@deliveryOutletImport');
    Route::post('/setting/delivery-outlet/import-save', 'TransactionController@deliveryOutletImport');
    Route::get('/setting/export/delivery-outlet', 'TransactionController@exportDeliveryOutlet');
    Route::get('/setting/package-detail-delivery', 'TransactionController@packageDetailDelivery');
    Route::post('/setting/package-detail-delivery', 'TransactionController@packageDetailDelivery');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function () {
    Route::get('/setting/rule', 'TransactionController@ruleTransaction');
    Route::post('/setting/rule/update', 'TransactionController@ruleTransactionUpdate');
    Route::get('/internalcourier', 'TransactionController@internalCourier');

    Route::post('/manual-payment-save', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentSave']);
    Route::post('/manual-payment-update/{id}', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentUpdate']);

    Route::get('/point', 'TransactionController@pointUser');
    Route::get('/balance', 'TransactionController@balanceUser');
    Route::any('autoresponse/{subject}', ['middleware' => 'feature_control:93', 'uses' => 'TransactionController@autoResponse']);
    Route::group(['prefix' => 'manualpayment', 'middleware' => 'config_control:17'], function () {
        Route::any('/banks', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksList']);
        Route::any('/banks/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksCreate']);
        Route::get('/banks/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@banksDelete']);
        Route::any('/banks/method/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@bankMethodsCreate']);
        Route::any('/banks/method', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksMethodList']);
        Route::get('/banks/method/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@bankMethodsDelete']);

        Route::get('/', ['middleware' => 'feature_control:64', 'uses' => 'TransactionController@manualPaymentList']);
        Route::any('/list/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::any('/reset/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::get('/create', ['middleware' => 'feature_control:66', 'uses' => 'TransactionController@manualPaymentCreate']);
        Route::get('/edit/{slug}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentEdit']);
        Route::get('/detail/{slug}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentDetail']);
        Route::get('/delete/{slug}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@manualPaymentDelete']);
        Route::get('/getData/{slug}', 'TransactionController@manualPaymentGetData');
        Route::post('/method/save', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethod']);
        Route::post('/method/delete', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethodDelete']);

        Route::any('/confirm/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentConfirm']);
    });

    Route::post('retry-void-payment/retry', [ 'uses' => 'TransactionController@retryRefund']);

    Route::get('/admin/{receipt}/{phone}', 'TransactionController@adminOutlet');
    Route::get('/admin/{type}/{status}/{receipt}/{id}', 'TransactionController@adminOutletConfirm');
});

Route::group(['prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function () {
    Route::any('/web/view/detail', 'WebviewController@detail');
    Route::any('/web/view/detail/check', 'WebviewController@check');
    Route::any('/web/view/detail/point', 'WebviewController@detailPoint');
    Route::any('/web/view/detail/balance', 'WebviewController@detailBalance');
    Route::any('/web/view/trx', 'WebviewController@success');
    Route::any('/web/view/outletapp', 'WebviewController@receiptOutletapp');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function () {
   
    Route::group(['prefix' => 'sedot'], function () {
        Route::any('pending', ['middleware' => 'feature_control:69', 'uses' => 'TransactionSedotController@pending']);
        Route::any('proses', ['middleware' => 'feature_control:69', 'uses' => 'TransactionSedotController@proses']);
        Route::any('selesai', ['middleware' => 'feature_control:69', 'uses' => 'TransactionSedotController@selesai']);
        Route::any('completed', ['middleware' => 'feature_control:69', 'uses' => 'TransactionSedotController@complete']);
    });
    Route::group(['prefix' => 'kontraktor'], function () {
        Route::any('pending', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@pending']);
        Route::any('proses', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@proses']);
        Route::any('selesai', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@selesai']);
        Route::any('completed', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@complete']);
        Route::group(['prefix' => 'rab'], function () {
            Route::post('create', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@createRAB']);
            Route::any('delete', ['middleware' => 'feature_control:69', 'uses' => 'TransactionKontraktorController@deleteRAB']);
        });
    });
    Route::get('detail/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDetail']);
    Route::post('detail/step1/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@step1']);
    Route::post('detail/step', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@step']);
    
    Route::post('detail/kontraktor/step1/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@kontraktorStep1']);
    Route::post('detail/kontraktor/step', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@kontraktorStep']);
    
    Route::group(['prefix' => 'log-invalid-flag'], function () {
        Route::any('list', ['middleware' => 'feature_control:276', 'uses' => 'InvalidFlagController@listLogInvalidFlag']);
        Route::any('detail', ['middleware' => 'feature_control:276', 'uses' => 'InvalidFlagController@detailLogInvalidFlag']);
    });

    Route::group(['prefix' => 'invalid-flag'], function () {
        Route::any('detail/{id_transaction}', ['uses' => 'InvalidFlagController@detailTrx']);
        Route::any('mark-as-valid', ['middleware' => 'feature_control:275', 'uses' => 'InvalidFlagController@markAsValid']);
        Route::post('mark-as-invalid/add', ['uses' => 'InvalidFlagController@markAsInvalidAdd']);
        Route::post('mark-as-pending-invalid/add', ['uses' => 'InvalidFlagController@markAsPendingInvalidAdd']);
        Route::post('mark-as-valid/update', ['uses' => 'InvalidFlagController@markAsValidUpdate']);
        Route::any('mark-as-pending-invalid', ['middleware' => 'feature_control:274', 'uses' => 'InvalidFlagController@markAsPendingInvalid']);
        Route::any('mark-as-invalid', ['middleware' => 'feature_control:274', 'uses' => 'InvalidFlagController@markAsInvalid']);
    });

    Route::get('failed-void-payment', [ 'uses' => 'ManualRefundController@listFailedVoidPayment']);
    Route::post('failed-void-payment', [ 'uses' => 'ManualRefundController@filter']);
    Route::post('failed-void-payment/confirm', [ 'uses' => 'ManualRefundController@confirmManualRefund']);

    Route::any('/create/fake', 'TransactionController@fakeTransaction');
    Route::get('/delete/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDelete']);

    Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);
    Route::any('/{key}/{slug}/filter', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionFilter']);

    Route::any('/point/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@pointUserFilter']);
    Route::any('/balance/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@balanceUserFilter']);
    // Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);

    Route::any('list-export', [ 'uses' => 'TransactionController@listExport']);
    Route::any('export-action/{action}/{id}', [ 'uses' => 'TransactionController@actionExport']);
    Route::any('send-report-outlet', [ 'uses' => 'TransactionController@sendReportToOutlet']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'response-with-code', 'namespace' => 'Modules\Transaction\Http\Controllers'], function () {
    Route::any('/', [ 'middleware' => 'feature_control:306,308,309', 'uses' => 'AutoresponseCodeController@list']);
    Route::get('create', [ 'middleware' => 'feature_control:307', 'uses' => 'AutoresponseCodeController@create']);
    Route::post('store', [ 'middleware' => 'feature_control:307', 'uses' => 'AutoresponseCodeController@store']);
    Route::get('edit/{id}', [ 'middleware' => 'feature_control:308', 'uses' => 'AutoresponseCodeController@edit']);
    Route::post('update/{id}', [ 'middleware' => 'feature_control:308', 'uses' => 'AutoresponseCodeController@update']);
    Route::post('delete/code', [ 'middleware' => 'feature_control:309', 'uses' => 'AutoresponseCodeController@deleteCode']);
    Route::post('delete/autoresponse-code', [ 'middleware' => 'feature_control:309', 'uses' => 'AutoresponseCodeController@deleteAutoresponsecode']);
    Route::get('export-example', [ 'uses' => 'AutoresponseCodeController@exportExample']);
});
