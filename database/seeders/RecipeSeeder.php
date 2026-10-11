<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'jane@example.com')->first();
        $dinner = Category::where('name', 'Dinner')->first();
        $italian = Cuisine::where('name', 'Italian')->first();
        
        $pasta = Ingredient::where('name', 'Pasta')->first();
        $tomato = Ingredient::where('name', 'Tomato')->first();
        $garlic = Ingredient::where('name', 'Garlic')->first();
        $oliveOil = Ingredient::where('name', 'Olive Oil')->first();
        $parmesan = Ingredient::where('name', 'Parmesan Cheese')->first();

        // Recipe 1
        $recipe1 = Recipe::create([
            'user_id' => $user->id,
            'category_id' => $dinner->id,
            'cuisine_id' => $italian->id,
            'name' => 'Classic Tomato Garlic Pasta',
            'description' => 'A simple, quick, and incredibly flavorful classic Italian pasta dish made with fresh tomatoes and roasted garlic.',
            'food_type' => 'Vegetarian',
        ]);

        $recipe1->ingredients()->attach([
            $pasta->id => ['quantity' => 200, 'unit' => 'grams'],
            $tomato->id => ['quantity' => 4, 'unit' => 'medium'],
            $garlic->id => ['quantity' => 3, 'unit' => 'cloves'],
            $oliveOil->id => ['quantity' => 2, 'unit' => 'tbsp'],
            $parmesan->id => ['quantity' => 50, 'unit' => 'grams'],
        ]);

        $recipe1->preparationSteps()->createMany([
            ['step_number' => 1, 'instruction' => 'Bring a large pot of salted water to a boil. Add the pasta and cook until al dente.'],
            ['step_number' => 2, 'instruction' => 'While pasta cooks, heat olive oil in a large skillet over medium heat. Add minced garlic and sauté for 1 minute until fragrant.'],
            ['step_number' => 3, 'instruction' => 'Add chopped tomatoes to the skillet. Cook for 5-7 minutes until they break down into a sauce. Season with salt and pepper.'],
            ['step_number' => 4, 'instruction' => 'Drain the pasta, reserving a quarter cup of pasta water. Add pasta and water to the skillet, tossing to coat.'],
            ['step_number' => 5, 'instruction' => 'Serve immediately, garnished with freshly grated Parmesan cheese.'],
        ]);
        
        // Add a few likes
        $recipe1->likes()->create(['user_id' => User::where('role', 'admin')->first()->id]);
    }
}
