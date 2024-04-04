<?php

namespace App\Repositories;

use App\Interfaces\Repository\QuestionRepositoryInterface;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * Get all data sorted as specified in the argument
     * @param $descOrder
     */
    public function getAll(bool $descOrder = false)
    {
        return $descOrder ? Question::orderBy('id', 'DESC')->get() : Question::all();
    }

    /**
     * retrieve a question by ID
     * @return Question
     */
    public function getById(int $questionId): Question
    {
        return Question::findOrFail($questionId);
    }

    /**
     * Delete a question
     * @param int $questionId
     */
    public function delete(int $questionId)
    {
        return Question::destroy($questionId);
    }

    /**
     * Persist data to DB
     * @param $questionDetails
     */
    public function create(array $questionDetails)
    {
        return Question::create($questionDetails);
    }


    /**
     * Update DB resource
     * @param $questionId
     * @param array $newDetails
     */
    public function update($questionId, array $newDetails)
    {
        return Question::whereId($questionId)->update($newDetails);
    }


    /**
     * Get all questions with their answer options
     * this query can be made much shorter and optimized
     */
    public function getAllWithAnswers()
    {
        Log::channel('stderr')->info('fetching from repository, not cache');

        return  Question::with('answers')->where('is_published', true)->get()->map(function ($question) {

            $answers = $question->answers->map(function ($answer) use ($question) {
                $b = $answer->behaviours->filter(function ($behaviour) use ($question) {
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
     * Get all Questions with
     * @param int $questionId
     */
    public function getWithAnswersAndBehaviours(int $questionId)
    {
        if ($question = $this->getById($questionId)) {
            return $question->answers()->with(['behaviours' => function ($q) use ($question) {
                $q->wherePivot('question_id', $question->id);
            }])->get();
        }

        return null;
    }


    /**
     * Get the behaviours of questions and answers using ID
     * @param int $questionId
     * @param int $answerId
     */
    public function getQuestionAnswerBehaviourById(int $questionId, int $answerId)
    {
        if ($question = $this->getById($questionId)) {

            /** @var BelongsToMany */
            $questionBehaviours = optional($question)->behaviours();
            return optional($questionBehaviours)->wherePivot('answer_id', $answerId)?->first();
        }

        return null;
    }

    /**
     * synchronize pivoted tables
     * @param int $questionId
     * @param array $array
     */
    public function syncAnswers(int $questionId, array $array): array|null
    {
        if ($question = $this->getById($questionId)) {
            return $question->answers()->sync($array);
        }
        return null;
    }
}
