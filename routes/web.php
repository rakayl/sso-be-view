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

Route::get('/', function () {
    return redirect('login');
});

Route::get('logout', function () {
    session()->flush();
    return redirect('login');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('login', function () {
        if (!session()->has('username')) {
            return view('login');
        } else {
            return redirect('home');
        }
    });
    Route::post('login', 'Controller@login');
    Route::group(['middleware' => 'validate_session'], function () {
        Route::get('setrange', 'Controller@setrange')->name('setrange');
        Route::post('setfilter', 'Controller@setfilter')->name('setfilter');
        
        Route::get('home', 'Controller@getHome');
        Route::any('debugger', 'Controller@debugger');
        Route::any('fire/{path}', 'Controller@proxyAPI')->where(['path' => ".*"]);
        Route::get('home/{year}', 'Controller@getHome');
        Route::get('home/{year}/{month}', 'Controller@getHome');
        Route::get('profile', 'Controller@getProfile');
        Route::post('profile', 'Controller@updateProfile');
        Route::any('textreplace', ['middleware' => 'feature_control:82', 'uses' => 'Controller@getTextReplace']);
        Route::any('email-header-footer', ['middleware' => 'feature_control:97', 'uses' => 'Controller@getEmailHeaderFooter']);
        Route::post('summernote/picture/upload/{type}', 'Controller@uploadImageSummernote');
        Route::post('summernote/picture/delete/{type}', 'Controller@deleteImageSummernote');
        
        
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('cogs', 'HomeController@cogs');
            Route::get('omset', 'HomeController@omset');
            Route::get('categori', 'HomeController@categori');
            Route::get('depart/tertinggi', 'HomeController@departTertinggi');
            Route::get('depart/piutang', 'HomeController@departPiutang');
            Route::get('omset/outlet', 'HomeController@omsetOutlet');
            Route::get('vendor', 'HomeController@vendor');
            Route::get('home', 'HomeController@home');
        });
    });
});

Route::get('webview/default', function () {
    return view('webview.default');
});
