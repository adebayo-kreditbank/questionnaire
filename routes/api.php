<?php

use App\Http\Controllers\QuestionnaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** api/v1 */
Route::group(['prefix' => 'questionnaire'], function() {
    Route::get('/', [QuestionnaireController::class, 'index']);
    Route::post('/', [QuestionnaireController::class, 'store']);
});
