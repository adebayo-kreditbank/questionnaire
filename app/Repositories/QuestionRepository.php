<?php

namespace App\Repositories;

use App\Interfaces\Repository\QuestionRepositoryInterface;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function getAll()
    {
        return Question::all();
    }

    /**
     * retrieve a question by ID
     * @return Question
     */
    public function getById(int $questionId): Question
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

    /**
     * Get all questions with their answer options
     * this query can be further optimized.
     */
    public function getAllWithAnswers()
    {
        Log::channel('stderr')->info('fetching from repository, not cache');

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

    /**
     * Get the behaviours of questions and answers using ID
     */
    public function getQuestionAnswerBehaviourById(int $questionId, int $answerId)
    {
        $question = $this->getById($questionId);
        /** @var BelongsToMany */
        $questionBehaviours = optional($question)->behaviours();
        return optional($questionBehaviours)->wherePivot('answer_id', $answerId)?->first();
    }
}
