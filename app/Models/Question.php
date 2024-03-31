<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    /**
     * Many to Many relationship with Answer
     */
    public function answers(): BelongsToMany
    {
        # if 2nd arg not specified, answer_question might be used as default
        return $this->belongsToMany(Answer::class, 'que_ans_beh');
    }

    /**
     * Many to Many relationship with Behaviour
     */
    public function behaviours(): BelongsToMany
    {
        # if 2nd arg not specified, behaviour_question might be used as default
        return $this->belongsToMany(Behaviour::class, 'que_ans_beh');
    }
}
