<?php

namespace App\Repositories;

use App\Interfaces\Repository\QuestionRepositoryInterface;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function getAll()
    {
        return Question::all();
    }

    public function getAllById(int $questionId)
    {
        return Question::findOrFail($questionId);
    }

    public function delete(int $questionId)
    {
        return Question::destroy($questionId);
    }

    public function create(array $questionDetails)
    {
        return Question::create($questionDetails);
    }

    public function update($questionId, array $newDetails)
    {
        return Question::whereId($questionId)->update($newDetails);
    }

    public function getAllWithAnswers()
    {
        Log::channel('stderr')->info('fetching from repository');

        return  Question::with('answers')->get()->map(function ($question) {

            $answers = $question->answers->map(function($answer) use ($question) {
                $b = $answer->behaviours->filter(function($behaviour) use ($question) {
                    return $behaviour->pivot->question_id == $question->id;
                })->first();
                return [
                   'id' => $answer->id,
                   'answer' => $answer->answer,
                   'behaviour' => [
                     'id' => $b->id,
                     'goToChildQuestion' => $b->question_id
                   ]
                ];
            });

            return [
                "id" => $question->id,
                "question" => $question->question,
                "parent_question_id" => $question->parent_question_id,
                "answers" => $answers
            ];
        });
    }

    public function getAllWithAnswersAndBehaviour()
    {
    }
}
