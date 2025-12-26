<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $collectorId = Auth::id();

        $assignedRequests = EwasteRequest::where('collector_id', $collectorId)
            ->whereIn('status', ['assigned', 'collected'])
            ->with(['user', 'category'])
            ->get();

        $todaysPickups = EwasteRequest::where('collector_id', $collectorId)
            ->where('preferred_pickup_date', today())
            ->where('status', 'assigned')
            ->with(['user', 'category'])
            ->get();

        return view('collector.dashboard', compact('assignedRequests', 'todaysPickups'));
    }
}
