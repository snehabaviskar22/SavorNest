<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRecipes = Recipe::with(['user', 'category', 'cuisine'])
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();
            
        $categories = Category::take(6)->get();

        return view('home.index', compact('featuredRecipes', 'categories'));
    }
}
