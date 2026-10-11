<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status === 'banned') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Your account has been banned.');
        }

        return $next($request);
    }
}
