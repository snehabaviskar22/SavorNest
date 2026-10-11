<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            'Flour', 'Sugar', 'Salt', 'Black Pepper', 'Olive Oil', 
            'Butter', 'Eggs', 'Milk', 'Garlic', 'Onion', 
            'Tomato', 'Chicken Breast', 'Beef', 'Pasta', 'Rice',
            'Cheddar Cheese', 'Parmesan Cheese', 'Basil', 'Oregano', 'Lemon'
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create(['name' => $ingredient]);
        }
    }
}
