<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('recipes')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function ban(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot ban an administrator.');
        }

        $request->validate(['ban_reason' => 'required|string']);

        $user->update([
            'status' => 'banned',
            'banned_at' => now(),
            'ban_reason' => $request->ban_reason,
        ]);

        return back()->with('success', "User {$user->name} has been banned.");
    }

    public function unban(User $user)
    {
        $user->update([
            'status' => 'active',
            'banned_at' => null,
            'ban_reason' => null,
        ]);

        return back()->with('success', "User {$user->name} has been unbanned.");
    }
}
