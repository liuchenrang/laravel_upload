<?php
/**
 * Created by PhpStorm.
 * User: XingHuo
 * Date: 16/6/25
 * Time: 下午7:03
 */
Route::any('/upload/image', 'UploadController@image');
Route::any('/upload/file', 'UploadController@file');
//Route::get('/upload/form', 'UploadController@form');
Route::get('/upload/form', function () {
    return view('upload::form');
});