<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Breakfast', 'description' => 'Start your day right with these delicious morning recipes.'],
            ['name' => 'Lunch', 'description' => 'Perfect mid-day meals to keep you energized.'],
            ['name' => 'Dinner', 'description' => 'Hearty and satisfying recipes for the evening.'],
            ['name' => 'Dessert', 'description' => 'Sweet treats and baked goods to satisfy your cravings.'],
            ['name' => 'Snacks', 'description' => 'Quick bites for between meals.'],
            ['name' => 'Beverages', 'description' => 'Refreshing drinks, smoothies, and cocktails.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
