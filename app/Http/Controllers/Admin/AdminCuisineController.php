<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use Illuminate\Http\Request;

class AdminCuisineController extends Controller
{
    public function index()
    {
        $cuisines = Cuisine::withCount('recipes')->latest()->paginate(15);
        return view('admin.cuisines.index', compact('cuisines'));
    }

    public function create()
    {
        return view('admin.cuisines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines',
            'description' => 'nullable|string'
        ]);

        Cuisine::create($validated);
        return redirect()->route('admin.cuisines.index')->with('success', 'Cuisine created successfully.');
    }

    public function edit(Cuisine $cuisine)
    {
        return view('admin.cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, Cuisine $cuisine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines,name,' . $cuisine->id,
            'description' => 'nullable|string'
        ]);

        $cuisine->update($validated);
        return redirect()->route('admin.cuisines.index')->with('success', 'Cuisine updated successfully.');
    }

    public function destroy(Cuisine $cuisine)
    {
        if ($cuisine->recipes()->exists()) {
            return back()->with('error', 'Cannot delete cuisine because it is used in recipes.');
        }

        $cuisine->delete();
        return back()->with('success', 'Cuisine deleted successfully.');
    }
}
