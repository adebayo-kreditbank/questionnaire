<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class Question extends Model
{
    use HasFactory;

    /**
     * Many to Many relationship with Answer
     */
    public function answers(): BelongsToMany
    {
        # if 2nd arg not specified, answer_question might be used as default
        return $this->belongsToMany(Answer::class, 'que_ans_beh'); //->withPivot('behaviour_id');
    }

    /**
     * Many to Many relationship with Behaviour
     * @return BelongsToMany
     */
    public function behaviours(): BelongsToMany
    {
        # if 2nd arg not specified, behaviour_question might be used as default
        return $this->belongsToMany(Behaviour::class, 'que_ans_beh')->withPivot('answer_id');
    }

    public function ans(Collection $answers)
    {
        $id = $this->id;
        $newAnswers = $answers->map(function($answer) use ($id) {
            $b = $answer->behaviours->filter(function($behaviour) use ($id) {
                return $behaviour->pivot->question_id == $id;
            })->first();
            return [
               'id' => $answer->id,
               'answer' => $answer->answer,
               'behaviour' => [
                 'id' => $b->id,
                 'question_id' => $b->question_id
               ]
            ];
        });
        return $newAnswers;
    }
}
