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

        // create a super admin user with my email
        if(User::count() == 0) User::factory(1)->create([
            'email' => 'adsonet2016@gmail.com',
            'role_id' => 1
        ]);

        // create other users
        if(User::count() == 1) User::factory(5)->create();

        // create others
        $this->call([
            ProductSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            BehaviourSeeder::class,
            QuestionAnswerBahaviourSeeder::class
        ]);
    }
}
