<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\QuestionRepository;

class MappingQuestionResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "question" => $this->question,
            "mappedAnswers" => $this->answers->pluck('id'),
            "mappedAnswerWithBehaviour" => app(QuestionRepository::class)->getWithAnswersAndBehaviours($this->id)
        ];
    }
}
