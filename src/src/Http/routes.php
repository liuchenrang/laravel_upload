<?php
/**
 * Created by PhpStorm.
 * User: XingHuo
 * Date: 16/6/25
 * Time: 下午7:03
 */

$attributes = array_merge([
    'prefix' => 'upload',
], config('upload.routeAttributes', []));
Route::group($attributes, function () {
    Route::any('image', 'UploadController@image');
    Route::any('file', 'UploadController@file');
    Route::any('token', 'UploadController@token');
//    Route::get('/form', 'UploadController@form');
    Route::get('form', function () {
        return view('upload::form');
    });
});

