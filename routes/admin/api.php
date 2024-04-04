<?php

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\BehaviourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuestionController;
use App\Models\Behaviour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** 
 * api/v1/admin/ 
 * Admin Backend
 * */

Route::post('login', [UserController::class, 'login']);

/** Protected */
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [UserController::class, '']);

    /** Question */
    Route::group(['prefix' => 'questions'], function () {
        Route::get('/', [QuestionController::class, 'index']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::put('/{id}', [QuestionController::class, 'update'])->where(['id', '[0-9]+']);
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->where(['id', '[0-9]+']);
    });

    /** Answers */
    Route::group(['prefix' => 'answers'], function () {
        Route::get('/', [AnswerController::class, 'index']);
        Route::post('/', [AnswerController::class, 'store']);
        Route::put('/{id}', [AnswerController::class, 'update'])->where(['id', '[0-9]+']);
        Route::delete('/{id}', [AnswerController::class, 'destroy'])->where(['id', '[0-9]+']);
    });

    /** Mapping */
    Route::group(['prefix' => 'mappings'], function () {
        Route::get('questions', [QuestionController::class, 'getMapping']);
        Route::post('questions/{id}/answers', [QuestionController::class, 'storeMapping'])->where(['id', '[0-9]+']);
    });

    /** Behaviours */
    Route::group(['prefix' => 'behaviours'], function () {
        Route::get('/', [BehaviourController::class, 'index']);
        Route::put('/{id}/products', [BehaviourController::class, 'update']);
    });
});
