<?php

namespace App\Repositories;

use App\Interfaces\Repository\BehaviourRepositoryInterface;
use App\Models\Behaviour;
use Illuminate\Support\Facades\Log;

class BehaviourRepository implements BehaviourRepositoryInterface
{
    public function getAll()
    {
        return Behaviour::all();
    }

    public function getById(int $questionId)
    {
        return Behaviour::findOrFail($questionId);
    }

    public function delete(int $questionId)
    {
        return Behaviour::destroy($questionId);
    }

    public function create(array $questionDetails)
    {
        return Behaviour::create($questionDetails);
    }

    public function update($questionId, array $newDetails)
    {
        return Behaviour::whereId($questionId)->update($newDetails);
    }

    public function getAllWithAnswers()
    {
        Log::channel('stderr')->info('fetching from repository');

        return  Behaviour::where('question_id')->get()->map(function ($question) {

        });
    }
}
