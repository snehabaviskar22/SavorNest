<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalRecipes = $user->recipes()->count();
        $totalLikesReceived = $user->recipes()->withCount('likes')->get()->sum('likes_count');
        
        $recentRecipes = $user->recipes()
            ->with(['category', 'cuisine'])
            ->withCount('likes')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('user', 'totalRecipes', 'totalLikesReceived', 'recentRecipes'));
    }
}
