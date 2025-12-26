<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        // Filter by role
        if ($request->has('role') && $request->role != 'all') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);
        $roles = Role::all();

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admins' => User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->count(),
            'collectors' => User::whereHas('roles', function ($q) {
                $q->where('name', 'collector');
            })->count(),
            'users' => User::whereHas('roles', function ($q) {
                $q->where('name', 'user');
            })->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['roles', 'submittedRequests.category', 'assignedRequests']);

        $requestStats = [
            'total_submitted' => $user->submittedRequests()->count(),
            'pending' => $user->submittedRequests()->where('status', 'pending')->count(),
            'approved' => $user->submittedRequests()->where('status', 'approved')->count(),
            'collected' => $user->submittedRequests()->where('status', 'collected')->count(),
            'assigned' => $user->assignedRequests()->where('status', 'assigned')->count(),
            'collected_as_collector' => $user->assignedRequests()->where('status', 'collected')->count(),
        ];

        return view('admin.users.show', compact('user', 'requestStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        Session::flash('success', 'User updated successfully!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            Session::flash('error', 'You cannot delete your own account!');
            return redirect()->back();
        }

        // Check if user has requests
        if ($user->submittedRequests()->count() > 0 || $user->assignedRequests()->count() > 0) {
            Session::flash('error', 'Cannot delete user with associated requests! Deactivate instead.');
            return redirect()->back();
        }

        $user->delete();

        Session::flash('success', 'User deleted successfully!');
        return redirect()->route('admin.users.index');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating self
        if ($user->id === auth()->id() && $user->is_active) {
            Session::flash('error', 'You cannot deactivate your own account!');
            return redirect()->back();
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        Session::flash('success', "User {$status} successfully!");

        return redirect()->back();
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::find($request->role_id);

        // Remove all existing roles (users can only have one role)
        $user->roles()->detach();

        // Assign new role
        $user->roles()->attach($role);

        // Update user status if needed
        if ($role->name == 'collector' || $role->name == 'admin') {
            $user->update(['is_active' => true]);
        }

        Session::flash('success', "User assigned as {$role->name} successfully!");
        return redirect()->back();
    }
}
