<?php

namespace App\Repositories;

use App\Interfaces\Repository\BehaviourRepositoryInterface;
use App\Models\Behaviour;
use Illuminate\Support\Facades\Log;

class BehaviourRepository implements BehaviourRepositoryInterface
{
    public function getAll(bool $descOrder = false)
    {
        return $descOrder ? Behaviour::orderBy('id', 'DESC')->get() : Behaviour::all();
    }

    public function getById(int $behaviourId)
    {
        return Behaviour::findOrFail($behaviourId);
    }

    public function delete(int $behaviourId)
    {
        return Behaviour::destroy($behaviourId);
    }

    public function create(array $behaviourDetails)
    {
        return Behaviour::create($behaviourDetails);
    }

    public function update($behaviourId, array $newDetails)
    {
        return Behaviour::whereId($behaviourId)->update($newDetails);
    }

    public function getAllWithPivot(bool $descOrder = false)
    {
        $behaviour = $descOrder ? Behaviour::orderBy('id', 'DESC') : Behaviour::orderBy('id', 'ASC');
        return $behaviour->with(['answers', 'questions'])->get();
    }

    public function syncAnswerWithQuestion(Behaviour $behaviour, int $answerId, int $questionId): array|null
    {
        return $behaviour->answers()->sync([
            $answerId => ['question_id' => $questionId]
        ], true);
    }
}
