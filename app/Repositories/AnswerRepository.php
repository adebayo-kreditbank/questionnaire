<?php

namespace App\Repositories;

use App\Interfaces\Repository\AnswerRepositoryInterface;
use App\Models\Answer;

class AnswerRepository implements AnswerRepositoryInterface
{
    public function getAll(bool $descOrder = false)
    {
        return $descOrder ? Answer::orderBy('id', 'DESC')->get() : Answer::all();
    }

    /**
     * retrieve a answer by ID
     * @return Answer
     */
    public function getById(int $answerId): Answer
    {
        return Answer::findOrFail($answerId);
    }

    public function delete(int $answerId)
    {
        return Answer::destroy($answerId);
    }

    public function create(array $answerDetails)
    {
        return Answer::create($answerDetails);
    }

    public function update($answerId, array $newDetails)
    {
        return Answer::whereId($answerId)->update($newDetails);
    }
}
