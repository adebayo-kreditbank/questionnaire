<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

class ProductSeeder extends Seeder
{
    private static array $names = [
        'Sildenafil 50mg',
        'Sildenafil 100mg',
        'Tadalafil 10mg',
        'Tadalafil 20mg'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Product::count() > 0) return;

        foreach (static::$names as $name) {
            Product::factory()->create([
                'name' => $name,
                'code' => Str::replace(' ', '_', Str::lower($name)),
                'category_id' => Category::all()->random()->id
            ]);
        }
    }
}
