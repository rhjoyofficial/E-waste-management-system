<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsCollector
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if (!Auth::user()->isCollector()) {
            // If user is not collector, redirect to appropriate dashboard
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Access denied. Collector only.');
            }
            return redirect()->route('user.dashboard')->with('error', 'Access denied. Collector only.');
        }

        return $next($request);
    }
}
