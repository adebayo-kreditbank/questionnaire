<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Question
 *
 * @property int          $id
 * @property string       $answer
 * @property Carbon       $date # derived column, see method getDateAttribute
 * @property Question     $questions
 * @property Behaviour    $behaviours
 */
class Answer extends Model
{
    use HasFactory;

    // protected $with = ['behaviours'];

    protected $fillable = [ "answer" ];

    /**
     * Many to Many relationship with Question
     */
    public function questions(): BelongsToMany
    {
        # if 2nd arg not specified, question_answer might be used as default
        return $this->belongsToMany(Question::class, 'que_ans_beh')->withPivot('behaviour_id');;
    }

    /**
     * Many to Many relationship with Behaviour
     */
    public function behaviours(): BelongsToMany
    {
        # if 2nd arg not specified, behaviour_answer might be used as default
        return $this->belongsToMany(Behaviour::class, 'que_ans_beh')->withPivot('question_id');;
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }
}
