<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class AdminIngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::withCount('recipes')->latest()->paginate(15);
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients'
        ]);

        Ingredient::create($validated);
        return redirect()->route('admin.ingredients.index')->with('success', 'Ingredient created successfully.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id
        ]);

        $ingredient->update($validated);
        return redirect()->route('admin.ingredients.index')->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        if ($ingredient->recipes()->exists()) {
            return back()->with('error', 'Cannot delete ingredient because it is used in recipes.');
        }

        $ingredient->delete();
        return back()->with('success', 'Ingredient deleted successfully.');
    }
}
