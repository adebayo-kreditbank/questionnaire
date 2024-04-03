<?php

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** api/v1/admin/ */

Route::post('login', [UserController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [UserController::class, '']);

    Route::group(['prefix' => 'questions'], function() { 
        Route::get('/', [QuestionController::class, 'index']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::put('/{id}', [QuestionController::class, 'update'])->where(['id', '[0-9]+']);
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->where(['id', '[0-9]+']);
    });

    Route::group(['prefix' => 'answers'], function() { 
        Route::get('/', [AnswerController::class, 'index']);
        Route::post('/', [AnswerController::class, 'store']);
        Route::put('/{id}', [AnswerController::class, 'update'])->where(['id', '[0-9]+']);
        Route::delete('/{id}', [AnswerController::class, 'destroy'])->where(['id', '[0-9]+']);
    });

});
