<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Ingredient;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'recipes' => Recipe::count(),
            'categories' => Category::count(),
            'cuisines' => Cuisine::count(),
            'ingredients' => Ingredient::count(),
            'banned_users' => User::where('status', 'banned')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
