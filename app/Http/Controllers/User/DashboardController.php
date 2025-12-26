<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total_requests' => EwasteRequest::where('user_id', $userId)->count(),
            'pending_requests' => EwasteRequest::where('user_id', $userId)->where('status', 'pending')->count(),
            'approved_requests' => EwasteRequest::where('user_id', $userId)->where('status', 'approved')->count(),
            'collected_requests' => EwasteRequest::where('user_id', $userId)->where('status', 'collected')->count(),
            'recycled_requests' => EwasteRequest::where('user_id', $userId)->where('status', 'recycled')->count(),
        ];

        $recentRequests = EwasteRequest::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentRequests'));
    }
}
