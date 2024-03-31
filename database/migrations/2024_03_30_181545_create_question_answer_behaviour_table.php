<?php

use App\Models\Answer;
use App\Models\Behaviour;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        # dont use 'question_answer_behaviour' 
        # to avoid Syntax error or access violation 'Identifier name Too Long'
        Schema::create('que_ans_beh', function (Blueprint $table) { 
            $table->foreignId('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreignId('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->foreignId('behaviour_id')->references('id')->on('behaviours')->onDelete('cascade');

            $table->unique(['question_id', 'answer_id', 'behaviour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('que_ans_beh');
    }
};
