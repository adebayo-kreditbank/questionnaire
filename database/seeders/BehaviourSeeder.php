<?php

namespace Database\Seeders;

use App\Models\Behaviour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BehaviourSeeder extends Seeder
{
    private static array $behaviours = [
        ['question_id' => null, 'product_included' => [['category'=>1]], 'product_excluded' => null],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => 3, 'product_included' => null, 'product_excluded' => null],
        ['question_id' => 4, 'product_included' => null, 'product_excluded' => null],
        ['question_id' => 5, 'product_included' => null, 'product_excluded' => null],
        ['question_id' => 5, 'product_included' => [1,3], 'product_excluded' => null],
        ['question_id' => null, 'product_included' => [1], 'product_excluded' => [3,4]],
        ['question_id' => null, 'product_included' => [4], 'product_excluded' => [1,2]],
        ['question_id' => null, 'product_included' => [3], 'product_excluded' => [1,2]],
        ['question_id' => null, 'product_included' => [2], 'product_excluded' => [3,4]],
        ['question_id' => null, 'product_included' => [2], 'product_excluded' => [3,4]],
        ['question_id' => null, 'product_included' => [4], 'product_excluded' => [1,2]],
        ['question_id' => null, 'product_included' => [2,4], 'product_excluded' => null],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => null],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => [['category'=>1]]],
        ['question_id' => null, 'product_included' => null, 'product_excluded' => null]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Behaviour::count() > 0) return;

        foreach(static::$behaviours as $behaviour) {
            Behaviour::factory()->create($behaviour);
        }
    }
}
