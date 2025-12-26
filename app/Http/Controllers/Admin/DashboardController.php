<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EwasteRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->count(),
            'total_collectors' => User::whereHas('roles', function ($q) {
                $q->where('name', 'collector');
            })->count(),
            'total_requests' => EwasteRequest::count(),
            'pending_requests' => EwasteRequest::where('status', 'pending')->count(),
            'approved_requests' => EwasteRequest::where('status', 'approved')->count(),
            'assigned_requests' => EwasteRequest::where('status', 'assigned')->count(),
            'collected_requests' => EwasteRequest::where('status', 'collected')->count(),
            'recycled_requests' => EwasteRequest::where('status', 'recycled')->count(),
        ];

        $recentRequests = EwasteRequest::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}
