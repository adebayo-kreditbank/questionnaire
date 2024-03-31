<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create role
        $this->call([RoleSeeder::class]);

        // create category
        if(Category::count() == 0) Category::factory()->create();

        // create user
        if(User::count() == 0) User::factory(5)->create();

        // create others
        $this->call([
            ProductSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            BehaviourSeeder::class,
            QuestionAnswerBahaviourSeeder::class
        ]);

        

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
