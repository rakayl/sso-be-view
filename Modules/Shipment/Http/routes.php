<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'shipment', 'namespace' => 'Modules\Shipment\Http\Controllers'], function () {
    Route::get('/', 'ShipmentController@index');
});
