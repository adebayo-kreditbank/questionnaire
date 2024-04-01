<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this['id'],
            "question" => $this['question'],
            "parentQuestionId" => $this['parent_question_id'],
            "isChildQuestion" => is_int($this['parent_question_id']),
            "answerOptions" => $this['answers']
        ];
    }
}
