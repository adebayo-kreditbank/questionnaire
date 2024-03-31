<?php

namespace Database\Seeders;

use App\Models\Behaviour;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionAnswerBahaviourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Question::find(1)->answers()->whereIn('answer_id', [1,2,3,4,5,6])->exists()) return;
        
        $questions = Question::all();

        foreach ($questions as $question) {
            # match() is not applicable here, multiple statement involved
            switch ($question->id) {
                case 1:
                    $question->answers()->attach(1, ['behaviour_id' => 1]);
                    $question->answers()->attach(2, ['behaviour_id' => 2]);
                    break;
                case 2:
                    $question->answers()->attach(2, ['behaviour_id' => 2]);
                    $question->answers()->attach(3, ['behaviour_id' => 3]);
                    $question->answers()->attach(4, ['behaviour_id' => 4]);
                    $question->answers()->attach(5, ['behaviour_id' => 5]);
                    break;
                case 3:
                    $question->answers()->attach(1, ['behaviour_id' => 6]);
                    $question->answers()->attach(2, ['behaviour_id' => 7]);
                    break;
                case 4:
                    $question->answers()->attach(1, ['behaviour_id' => 8]);
                    $question->answers()->attach(2, ['behaviour_id' => 9]);
                    break;
                case 5:
                    $question->answers()->attach(3, ['behaviour_id' => 10]);
                    $question->answers()->attach(4, ['behaviour_id' => 11]);
                    $question->answers()->attach(6, ['behaviour_id' => 12]);
                    break;
                case 6;
                    $question->answers()->attach(1, ['behaviour_id' => 13]);
                    $question->answers()->attach(2, ['behaviour_id' => 14]);
                    break;
                case 7;
                    $question->answers()->attach(7, ['behaviour_id' => 15]);
                    $question->answers()->attach(8, ['behaviour_id' => 16]);
                    $question->answers()->attach(9, ['behaviour_id' => 17]);
                    $question->answers()->attach(10, ['behaviour_id' => 18]);
                    $question->answers()->attach(11, ['behaviour_id' => 19]);
                    break;
                case 8;
                    $question->answers()->attach(12, ['behaviour_id' => 20]);
                    $question->answers()->attach(13, ['behaviour_id' => 21]);
                    $question->answers()->attach(14, ['behaviour_id' => 22]);
                    $question->answers()->attach(15, ['behaviour_id' => 23]);
                    $question->answers()->attach(16, ['behaviour_id' => 24]);
                    break;
            }
        }
    }
}
