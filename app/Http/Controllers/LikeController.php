<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Recipe $recipe)
    {
        if ($recipe->user_id === Auth::id()) {
            return back()->with('error', 'You cannot like your own recipe.');
        }

        $recipe->likes()->firstOrCreate([
            'user_id' => Auth::id()
        ]);

        return back()->with('success', 'Recipe liked successfully.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->likes()->where('user_id', Auth::id())->delete();
        
        return back()->with('success', 'Recipe unliked.');
    }
}
