<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product', 'namespace' => 'Modules\Product\Http\Controllers'], function () {
    /**
     * product
     */
    Route::get('/', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@listProduct']);
    Route::post('/', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@listProduct']);
    Route::any('/image/add', ['middleware' => 'feature_control:54', 'uses' => 'ProductController@addImage']);
    Route::any('/image/detail', ['middleware' => 'feature_control:53', 'uses' => 'ProductController@addImageDetail']);
    Route::any('/image/list', ['middleware' => 'feature_control:53', 'uses' => 'ProductController@listImage']);
    Route::any('/image/override', ['middleware' => 'feature_control:53', 'uses' => 'ProductController@overrideImage']);
    Route::any('/visible/{key?}', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@visibility']);
    Route::any('/hidden/{key?}', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@visibility']);
    Route::post('/id_visibility', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@addIdVisibility']);
    Route::post('update/visible', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@updateVisibilityProduct']);
    Route::get('import/{type}', ['middleware' => ['feature_control:56,57', 'config_control:10,11,or'], 'uses' => 'ProductController@importProduct']);
    Route::post('import/save', ['middleware' => ['feature_control:56', 'config_control:10'], 'uses' => 'ProductController@importProductSave']);
    Route::get('ajax', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@listProductAjax']);
    Route::get('ajax/simple', ['uses' => 'ProductController@listProductAjaxSimple']);
    Route::post('variant-combination', ['uses' => 'ProductController@variantCombination']);
    Route::any('create', ['middleware' => 'feature_control:50', 'uses' => 'ProductController@create']);
    Route::any('update', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@update']);
    Route::post('update/allow_sync', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@updateAllowSync']);
    Route::post('update/visibility/global', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@updateVisibility']);
    Route::any('delete', ['middleware' => 'feature_control:52', 'uses' => 'ProductController@delete']);
    Route::any('detail/{product_code}', ['middleware' => 'feature_control:49', 'uses' => 'ProductController@detail']);
    Route::post('export/{type}', ['middleware' => ['feature_control:57', 'config_control:11'], 'uses' => 'ProductController@export']);
    Route::post('import/{type}', ['middleware' => ['feature_control:56', 'config_control:10'], 'uses' => 'ProductController@import']);
    Route::any('price/{key?}', ['middleware' => ['feature_control:62', 'config_control:11'], 'uses' => 'ProductController@price']);
    Route::any('outlet-detail/{key?}', ['middleware' => ['feature_control:62', 'config_control:11'], 'uses' => 'ProductController@productOutletDetail']);
    Route::any('category/assign', ['middleware' => ['feature_control:44', 'config_control:11'], 'uses' => 'ProductController@categoryAssign']);
    Route::any('recommendation', ['uses' => 'ProductController@productRecommendation']);

    Route::get('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'ProductController@positionAssign']);
    // ajax for ordering position
    Route::post('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'ProductController@positionProductAssign']);

    Route::get('ajax-product-brand', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@ajaxProductBrand']);
    /**
     * photo
     */
    Route::group(['prefix' => 'photo'], function () {
        Route::any('delete', ['middleware' => 'feature_control:53', 'uses' => 'ProductController@deletePhoto']);
        Route::any('default', ['middleware' => 'feature_control:53', 'uses' => 'ProductController@photoDefault']);
    });

    /**
     * category
     */
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', ['middleware' => 'feature_control:43', 'uses' => 'CategoryController@categoryList']);
        Route::get('edit/{id}', ['middleware' => 'feature_control:44', 'uses' => 'CategoryController@edit']);
        Route::post('update/{id}', ['middleware' => 'feature_control:44', 'uses' => 'CategoryController@update']);
        Route::any('create', ['middleware' => 'feature_control:45', 'uses' => 'CategoryController@store']);
        Route::post('delete/{id}', ['middleware' => 'feature_control:47', 'uses' => 'CategoryController@delete']);
        /* position/ order */
        Route::post('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'CategoryController@positionCategoryAssign']);
    });

    /**
     * promo category
     */
    Route::group(['prefix' => 'promo-category'], function () {
        Route::get('/', ['middleware' => 'feature_control:236', 'uses' => 'PromoCategoryController@index']);
        Route::post('/', ['middleware' => 'feature_control:236', 'uses' => 'PromoCategoryController@indexAjax']);
        Route::get('create', ['middleware' => 'feature_control:239', 'uses' => 'PromoCategoryController@create']);
        Route::post('create', ['middleware' => 'feature_control:239', 'uses' => 'PromoCategoryController@store']);
        Route::post('delete', ['middleware' => 'feature_control:240', 'uses' => 'PromoCategoryController@destroy']);
        /* position/ order */
        Route::post('reorder', ['middleware' => ['feature_control:238'], 'uses' => 'PromoCategoryController@reorder']);
        Route::get('{id}', ['middleware' => 'feature_control:237', 'uses' => 'PromoCategoryController@show']);
        Route::post('{id}', ['middleware' => 'feature_control:238', 'uses' => 'PromoCategoryController@update']);
        Route::post('{id}/assign', ['middleware' => ['feature_control:238'], 'uses' => 'PromoCategoryController@assign']);
    });

    /**
     * modifier
     */
    Route::group(['prefix' => 'modifier'], function () {
        Route::get('price/{id_outlet?}', ['middleware' => 'feature_control:185', 'uses' => 'ModifierController@listPrice']);
        Route::post('price/{id_outlet}', ['middleware' => 'feature_control:186', 'uses' => 'ModifierController@updatePrice']);
        Route::get('detail/{id_outlet?}', ['middleware' => 'feature_control:185', 'uses' => 'ModifierController@listDetail']);
        Route::post('detail/{id_outlet}', ['middleware' => 'feature_control:186', 'uses' => 'ModifierController@updateDetail']);

        Route::get('position', ['uses' => 'ModifierController@position']);
        Route::post('position/assign', ['middleware' => 'feature_control:183', 'uses' => 'ModifierController@positionAssign']);

        Route::get('inventory-brand', ['middleware' => 'feature_control:183', 'uses' => 'ModifierController@inventoryBrand']);
        Route::post('inventory-brand', ['middleware' => 'feature_control:183', 'uses' => 'ModifierController@inventoryBrandUpdate']);

        Route::get('/', ['middleware' => 'feature_control:180', 'uses' => 'ModifierController@index']);
        Route::get('/create', ['middleware' => 'feature_control:181', 'uses' => 'ModifierController@create']);
        Route::post('/', ['middleware' => 'feature_control:181', 'uses' => 'ModifierController@store']);
        Route::get('/{id}', ['middleware' => 'feature_control:182', 'uses' => 'ModifierController@show']);
        Route::put('/{id}', ['middleware' => 'feature_control:183', 'uses' => 'ModifierController@update']);
        Route::patch('/{id}', ['middleware' => 'feature_control:183', 'uses' => 'ModifierController@update']);
        Route::delete('/{id}', ['middleware' => 'feature_control:184', 'uses' => 'ModifierController@destroy']);
    });

    /**
     * modifier group
     */
    Route::group(['prefix' => 'modifier-group'], function () {
        Route::get('/', ['middleware' => 'feature_control:283', 'uses' => 'ModifierGroupController@index']);
        Route::get('create', ['middleware' => 'feature_control:284', 'uses' => 'ModifierGroupController@create']);
        Route::post('/', ['middleware' => 'feature_control:284', 'uses' => 'ModifierGroupController@store']);
        Route::get('edit/{id}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@update']);
        Route::post('update/{id}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@update']);
        Route::post('delete/{id}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@destroy']);
        Route::get('price/{id_outlet?}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@listPrice']);
        Route::post('price/{id_outlet}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@updatePrice']);
        Route::get('detail/{id_outlet?}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@listDetail']);
        Route::post('detail/{id_outlet}', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@updateDetail']);
        Route::post('export', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@export']);
        Route::get('import', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@import']);
        Route::post('import/save', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@importSave']);
        Route::post('export-price', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@exportPrice']);
        Route::get('import-price', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@importPrice']);
        Route::post('import-price/save', ['middleware' => ['feature_control:286'], 'uses' => 'ModifierGroupController@importSavePrice']);

        Route::get('position', ['uses' => 'ModifierGroupController@position']);
        Route::post('position/assign', ['uses' => 'ModifierGroupController@positionAssign']);

        Route::get('inventory-brand', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@inventoryBrand']);
        Route::post('inventory-brand', ['middleware' => 'feature_control:286', 'uses' => 'ModifierGroupController@inventoryBrandUpdate']);
    });

    /**
     * product_variant_group
     */
    Route::group(['prefix' => 'product-variant-group'], function () {
        Route::post('delete', ['uses' => 'ProductController@deleteProductVarianGroup']);
        Route::post('{product_code}', ['uses' => 'ProductController@productVarianGroup']);
    });

    /**
     * discount
     */
    Route::group(['prefix' => 'discount'], function () {
        Route::any('delete', 'ProductController@deleteDiscount');
    });

    /**
     * tag
     */
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/', ['middleware' => 'feature_control:43', 'uses' => 'TagController@list']);
        Route::post('create', ['middleware' => 'feature_control:45', 'uses' => 'TagController@create']);
        Route::post('update', ['middleware' => 'feature_control:44', 'uses' => 'TagController@update']);
        Route::post('delete', ['middleware' => 'feature_control:47', 'uses' => 'TagController@delete']);
        Route::get('detail/{id}', ['middleware' => 'feature_control:47', 'uses' => 'TagController@listProductTag']);
        Route::post('delete/product-tag', ['middleware' => 'feature_control:47', 'uses' => 'TagController@deleteProductTag']);
        Route::post('create/product-tag', ['middleware' => 'feature_control:47', 'uses' => 'TagController@createTagProduct']);
    });
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product', 'namespace' => 'Modules\Advert\Http\Controllers'], function () {
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});
