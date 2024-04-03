<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    private static array $questions = [
        ['question' => 'Do you have difficulty getting or maintaining an erection?', 'parent_question_id'=>null, 'is_published'=>true],
        ['question' => 'Have you tried any of the following treatments before?', 'parent_question_id'=>null, 'is_published'=>true],
        ['question' => 'Was the Viagra or Sildenafil product you tried before effective?', 'parent_question_id'=>2, 'is_published'=>true],
        ['question' => 'Was the Cialis or Tadalafil product you tried before effective?', 'parent_question_id'=>2, 'is_published'=>true],
        ['question' => 'Which is your preferred treatment?', 'parent_question_id'=>2, 'is_published'=>true],
        ['question' => 'Do you have, or have you ever had, any heart or neurological conditions?', 'parent_question_id'=>null, 'is_published'=>true],
        ['question' => 'Do any of the listed medical conditions apply to you?', 'parent_question_id'=>null, 'is_published'=>true],
        ['question' => 'Are you taking any of the following drugs?', 'parent_question_id'=>null, 'is_published'=>true],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Question::count() > 0) return;

        foreach(static::$questions as $question) {
            Question::factory()->create($question);
        }
    }
}
