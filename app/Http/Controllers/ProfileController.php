<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $recipes = $user->recipes()->with(['category', 'cuisine'])->withCount('likes')->latest()->paginate(9);
        $totalLikes = $user->recipes()->withCount('likes')->get()->sum('likes_count');
        
        return view('profile.show', compact('user', 'recipes', 'totalLikes'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
