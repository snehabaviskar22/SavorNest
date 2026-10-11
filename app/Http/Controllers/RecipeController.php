<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with(['user', 'category', 'cuisine'])->withCount('likes');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('cuisine')) {
            $query->where('cuisine_id', $request->cuisine);
        }

        if ($request->filled('food_type')) {
            $query->where('food_type', $request->food_type);
        }

        if ($request->sort === 'popular') {
            $query->orderBy('likes_count', 'desc');
        } else {
            $query->latest();
        }

        $recipes = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $cuisines = Cuisine::all();

        return view('recipes.index', compact('recipes', 'categories', 'cuisines'));
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['user', 'category', 'cuisine', 'ingredients', 'preparationSteps']);
        $recipe->loadCount('likes');
        
        $userLiked = Auth::check() ? $recipe->likes()->where('user_id', Auth::id())->exists() : false;

        return view('recipes.show', compact('recipe', 'userLiked'));
    }

    public function myRecipes()
    {
        $recipes = Auth::user()->recipes()->with(['category', 'cuisine'])->withCount('likes')->latest()->paginate(10);
        return view('recipes.my-recipes', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        $cuisines = Cuisine::all();
        
        return view('recipes.create', compact('categories', 'cuisines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cuisine_id' => 'required|exists:cuisines,id',
            'food_type' => 'required|in:Vegetarian,Non-Vegetarian,Vegan',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|numeric|min:0.1',
            'ingredients.*.unit' => 'required|string|max:50',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $imagePath = $request->file('image')->store('recipes', 'public');

            $recipe = Auth::user()->recipes()->create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'cuisine_id' => $validated['cuisine_id'],
                'food_type' => $validated['food_type'],
                'image' => $imagePath,
            ]);

            $ingredientData = [];
            foreach ($validated['ingredients'] as $ingredientInput) {
                $name = trim($ingredientInput['name']);
                
                // Find existing (case-insensitive) or create new
                $ingredient = Ingredient::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
                if (!$ingredient) {
                    $ingredient = Ingredient::create(['name' => $name]);
                }
                
                $ingredientData[$ingredient->id] = [
                    'quantity' => $ingredientInput['quantity'],
                    'unit' => $ingredientInput['unit'],
                ];
            }
            $recipe->ingredients()->sync($ingredientData);

            $stepsData = [];
            foreach ($validated['steps'] as $index => $instruction) {
                $stepsData[] = [
                    'step_number' => $index + 1,
                    'instruction' => $instruction,
                ];
            }
            $recipe->preparationSteps()->createMany($stepsData);
        });

        return redirect()->route('my-recipes')->with('success', 'Recipe created successfully.');
    }

    public function edit(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            abort(403);
        }

        $recipe->load(['ingredients', 'preparationSteps']);
        $categories = Category::all();
        $cuisines = Cuisine::all();

        return view('recipes.edit', compact('recipe', 'categories', 'cuisines'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cuisine_id' => 'required|exists:cuisines,id',
            'food_type' => 'required|in:Vegetarian,Non-Vegetarian,Vegan',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|numeric|min:0.1',
            'ingredients.*.unit' => 'required|string|max:50',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $request, $recipe) {
            $dataToUpdate = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'cuisine_id' => $validated['cuisine_id'],
                'food_type' => $validated['food_type'],
            ];

            if ($request->hasFile('image')) {
                if ($recipe->image) {
                    Storage::disk('public')->delete($recipe->image);
                }
                $dataToUpdate['image'] = $request->file('image')->store('recipes', 'public');
            }

            $recipe->update($dataToUpdate);

            $ingredientData = [];
            foreach ($validated['ingredients'] as $ingredientInput) {
                $name = trim($ingredientInput['name']);
                
                // Find existing (case-insensitive) or create new
                $ingredient = Ingredient::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
                if (!$ingredient) {
                    $ingredient = Ingredient::create(['name' => $name]);
                }
                
                $ingredientData[$ingredient->id] = [
                    'quantity' => $ingredientInput['quantity'],
                    'unit' => $ingredientInput['unit'],
                ];
            }
            $recipe->ingredients()->sync($ingredientData);

            $recipe->preparationSteps()->delete();
            $stepsData = [];
            foreach ($validated['steps'] as $index => $instruction) {
                $stepsData[] = [
                    'step_number' => $index + 1,
                    'instruction' => $instruction,
                ];
            }
            $recipe->preparationSteps()->createMany($stepsData);
        });

        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated successfully.');
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            abort(403);
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        
        $recipe->delete();

        return redirect()->route('my-recipes')->with('success', 'Recipe deleted successfully.');
    }
}
