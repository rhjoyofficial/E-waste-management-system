<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use App\Models\User;
use App\Models\Category;
use App\Models\RequestStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EwasteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EwasteRequest::with(['user', 'collector', 'category'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter by date
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $requests = $query->paginate(20);
        $categories = Category::active()->get();

        $statusCounts = [
            'all' => EwasteRequest::count(),
            'pending' => EwasteRequest::where('status', 'pending')->count(),
            'approved' => EwasteRequest::where('status', 'approved')->count(),
            'assigned' => EwasteRequest::where('status', 'assigned')->count(),
            'collected' => EwasteRequest::where('status', 'collected')->count(),
            'recycled' => EwasteRequest::where('status', 'recycled')->count(),
            'rejected' => EwasteRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.requests.index', compact('requests', 'categories', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(EwasteRequest $ewaste_request)
    {
        $ewaste_request->load(['user', 'collector', 'category', 'statusLogs.changedBy']);
        $collectors = User::whereHas('roles', function ($q) {
            $q->where('name', 'collector');
        })->where('is_active', true)->get();

        return view('admin.requests.show', compact('ewaste_request', 'collectors'));
    }

    /**
     * Assign collector to request
     */
    public function assignCollector(Request $request, EwasteRequest $ewaste_request)
    {
        $request->validate([
            'collector_id' => 'required|exists:users,id'
        ]);

        // Verify user is a collector
        $collector = User::find($request->collector_id);
        if (!$collector->isCollector()) {
            Session::flash('Selected user is not a collector!', 'error');
            return redirect()->back();
        }

        $ewaste_request->update([
            'collector_id' => $request->collector_id,
            'status' => 'assigned'
        ]);

        // Log status change
        RequestStatusLog::create([
            'ewaste_request_id' => $ewaste_request->id,
            'status' => 'assigned',
            'changed_by' => auth()->id(),
            'remarks' => "Assigned to collector: {$collector->name}"
        ]);

        Session::flash('Collector assigned successfully!', 'success');
        return redirect()->back();
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, EwasteRequest $ewaste_request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,collected,recycled',
            'remarks' => 'nullable|string'
        ]);

        $oldStatus = $ewaste_request->status;
        $newStatus = $request->status;

        $ewaste_request->update([
            'status' => $newStatus,
            'admin_remark' => $request->remarks
        ]);

        // Log status change
        RequestStatusLog::create([
            'ewaste_request_id' => $ewaste_request->id,
            'status' => $newStatus,
            'changed_by' => auth()->id(),
            'remarks' => "Status changed from {$oldStatus} to {$newStatus}. " . ($request->remarks ? "Remarks: {$request->remarks}" : "")
        ]);

        Session::flash("Request status updated to {$newStatus}!", 'success');
        return redirect()->back();
    }

    /**
     * Update admin remarks
     */
    public function updateRemark(Request $request, EwasteRequest $ewaste_request)
    {
        $request->validate([
            'admin_remark' => 'nullable|string'
        ]);

        $ewaste_request->update([
            'admin_remark' => $request->admin_remark
        ]);

        Session::flash('Remarks updated successfully!', 'success');
        return redirect()->back();
    }
}
