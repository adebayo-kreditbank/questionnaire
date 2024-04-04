<?php

use App\Http\Controllers\QuestionnaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** Health check */
Route::get('health-check', function(){
    return response()->json(["App is healthy"]);
});

/**
 * api/v1
 * Questionnaire
 * @see ./admin/api.php for the admin backend
 */
Route::group(['prefix' => 'questionnaire'], function() {
    Route::get('/', [QuestionnaireController::class, 'index'])->name('questionnaire.get');
    Route::post('/', [QuestionnaireController::class, 'store'])->name('questionnaire.post');
});
