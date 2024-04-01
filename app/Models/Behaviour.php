<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Behaviour extends Model
{
    use HasFactory;

    protected $casts = [
        'product_included' => 'array',
        'product_excluded' => 'array',
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    /**
     * Many to Many relationship with Answer
     */
    public function answers(): BelongsToMany
    {
        # if 2nd arg not specified, answer_behaviour might be used as default
        return $this->belongsToMany(Answer::class, 'que_ans_beh'); //->withPivot('question_id');
    }

    /**
     * Many to Many relationship with Question
     */
    public function questions(): BelongsToMany
    {
        # if 2nd arg not specified, question_behaviour might be used as default
        return $this->belongsToMany(Question::class, 'que_ans_beh'); //->withPivot('answer_id');
    }
}
