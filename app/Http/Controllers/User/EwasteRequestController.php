<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EwasteRequest;
use App\Models\Category;
use App\Models\RequestStatusLog;
use App\Traits\HasFlashMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EwasteRequestController extends Controller
{
    use HasFlashMessages;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Auth::user()->submittedRequests()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('user.requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $deviceConditions = ['working', 'damaged', 'dead'];

        return view('user.requests.create', compact('categories', 'deviceConditions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'device_condition' => 'required|in:working,damaged,dead',
            'quantity' => 'required|integer|min:1|max:100',
            'pickup_address' => 'required|string|min:10|max:1000',
            'preferred_pickup_date' => 'nullable|date|after:today',
            'user_note' => 'nullable|string|max:500'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $ewasteRequest = EwasteRequest::create($validated);

        // Log initial status
        RequestStatusLog::create([
            'ewaste_request_id' => $ewasteRequest->id,
            'status' => 'pending',
            'changed_by' => Auth::id(),
            'remarks' => 'Request submitted'
        ]);

        // Use session flash instead of helper
        Session::flash('success', 'E-waste pickup request submitted successfully!');

        return redirect()->route('user.requests.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EwasteRequest $request)
    {
        // Ensure user can only view their own requests
        if ($request->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $request->load(['category', 'collector', 'statusLogs.changedBy']);
        return view('user.requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EwasteRequest $request)
    {
        // Ensure user can only edit their own pending requests
        if ($request->user_id !== Auth::id() || !$request->isPending()) {
            abort(403, 'Unauthorized access or request cannot be edited.');
        }

        $categories = Category::active()->get();
        $deviceConditions = ['working', 'damaged', 'dead'];

        return view('user.requests.edit', compact('request', 'categories', 'deviceConditions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EwasteRequest $ewaste_request)
    {
        // Ensure user can only update their own pending requests
        if ($ewaste_request->user_id !== Auth::id() || !$ewaste_request->isPending()) {
            abort(403, 'Unauthorized access or request cannot be updated.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'device_condition' => 'required|in:working,damaged,dead',
            'quantity' => 'required|integer|min:1|max:100',
            'pickup_address' => 'required|string|min:10|max:1000',
            'preferred_pickup_date' => 'nullable|date|after:today',
            'user_note' => 'nullable|string|max:500'
        ]);

        $ewaste_request->update($validated);

        Session::flash('success', 'Request updated successfully!');
        return redirect()->route('user.requests.show', $ewaste_request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EwasteRequest $ewaste_request)
    {
        // Ensure user can only delete their own pending requests
        if ($ewaste_request->user_id !== Auth::id() || !$ewaste_request->isPending()) {
            abort(403, 'Unauthorized access or request cannot be deleted.');
        }

        $ewaste_request->delete();

        Session::flash('success', 'Request cancelled successfully!');
        return redirect()->route('user.requests.index');
    }

    /**
     * Cancel a pending request
     */
    public function cancel(EwasteRequest $ewaste_request)
    {
        return $this->destroy($ewaste_request);
    }
}
