<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** api/v1/admin/ */
Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => ['auth:sanctum']], function(){
        Route::get('/user', []);
    });

});
