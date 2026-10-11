<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $recipes = $category->recipes()->with(['user', 'cuisine'])->withCount('likes')->paginate(12);
        return view('categories.show', compact('category', 'recipes'));
    }
}
