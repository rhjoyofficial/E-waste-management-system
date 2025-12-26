<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EwasteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collectorId = Auth::id();

        $assignedRequests = EwasteRequest::where('collector_id', $collectorId)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('collector.requests.index', compact('assignedRequests'));
    }

    /**
     * Mark request as collected
     */
    public function markCollected(Request $request, EwasteRequest $ewaste_request)
    {
        // Verify request is assigned to this collector
        if ($ewaste_request->collector_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Verify request is in assigned status
        if (!$ewaste_request->isAssigned()) {
            Session::flash('Only assigned requests can be marked as collected!', 'error');
            return redirect()->back();
        }

        $request->validate([
            'collector_remark' => 'nullable|string|max:500'
        ]);

        $ewaste_request->update([
            'status' => 'collected',
            'collector_remark' => $request->collector_remark
        ]);

        // Log status change
        \App\Models\RequestStatusLog::create([
            'ewaste_request_id' => $ewaste_request->id,
            'status' => 'collected',
            'changed_by' => Auth::id(),
            'remarks' => 'Items collected. ' . ($request->collector_remark ? "Remarks: {$request->collector_remark}" : "")
        ]);

        Session::flash('Request marked as collected successfully!', 'success');
        return redirect()->back();
    }

    /**
     * Update collector remarks
     */
    public function updateRemark(Request $request, EwasteRequest $ewaste_request)
    {
        // Verify request is assigned to this collector
        if ($ewaste_request->collector_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'collector_remark' => 'nullable|string|max:500'
        ]);

        $ewaste_request->update([
            'collector_remark' => $request->collector_remark
        ]);

        Session::flash('Remarks updated successfully!', 'success');
        return redirect()->back();
    }

    /**
     * Get request details for modal
     */
    public function showDetails(EwasteRequest $ewaste_request)
    {
        // Verify request is assigned to this collector
        if ($ewaste_request->collector_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ewaste_request->load(['user', 'category']);

        return response()->json([
            'user' => [
                'name' => $ewaste_request->user->name,
                'email' => $ewaste_request->user->email
            ],
            'category' => ['name' => $ewaste_request->category->name],
            'device_condition' => $ewaste_request->device_condition,
            'quantity' => $ewaste_request->quantity,
            'pickup_address' => $ewaste_request->pickup_address,
            'preferred_pickup_date' => $ewaste_request->preferred_pickup_date ? $ewaste_request->preferred_pickup_date->format('M d, Y') : null,
            'user_note' => $ewaste_request->user_note
        ]);
    }
}
