<?php

namespace App\Repositories;

use App\Interfaces\Repository\AnswerRepositoryInterface;
use App\Models\Answer;

class AnswerRepository implements AnswerRepositoryInterface
{
    
    /**
     * Get all data sorted as specified in the argument
     * @param $descOrder
     */
    public function getAll(bool $descOrder = false)
    {
        return $descOrder ? Answer::orderBy('id', 'DESC')->get() : Answer::all();
    }


    /**
     * retrieve a answer by ID
     * @param int $answerId
     * @return Answer
     */
    public function getById(int $answerId): Answer
    {
        return Answer::findOrFail($answerId);
    }


    /**
     * Delete a answer
     * @param int $answerId
     */
    public function delete(int $answerId)
    {
        return Answer::destroy($answerId);
    }


    /**
     * Persist data to DB
     * @param $answerDetails
     */
    public function create(array $answerDetails)
    {
        return Answer::create($answerDetails);
    }


    /**
     * Update DB resource
     * @param $questionId
     * @param array $newDetails
     */
    public function update($answerId, array $newDetails)
    {
        return Answer::whereId($answerId)->update($newDetails);
    }
}
