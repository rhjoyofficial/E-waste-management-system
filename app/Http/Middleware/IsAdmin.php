<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if (!Auth::user()->isAdmin()) {
            // If user is not admin, redirect to appropriate dashboard
            if (Auth::user()->isCollector()) {
                return redirect()->route('collector.dashboard')->with('error', 'Access denied. Admin only.');
            }
            return redirect()->route('user.dashboard')->with('error', 'Access denied. Admin only.');
        }

        return $next($request);
    }
}
