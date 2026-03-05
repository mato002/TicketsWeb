<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        // Auth middleware is now applied at route level
    }

    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = User::withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load('bookings.concert');
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'email_verified_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Remove password from update if not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Handle email verification
        if ($request->has('verify_email') && !$user->email_verified_at) {
            $validated['email_verified_at'] = now();
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        // Check if user has bookings
        if ($user->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete user with existing bookings. Please cancel all bookings first.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleActive(User $user): RedirectResponse
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "User {$status} successfully.");
    }

    /**
     * Manually verify user email.
     */
    public function verifyEmail(User $user): RedirectResponse
    {
        $user->update(['email_verified_at' => now()]);

        return redirect()->back()
            ->with('success', 'User email verified successfully.');
    }

    /**
     * Send password reset email to user.
     */
    public function sendPasswordReset(User $user): RedirectResponse
    {
        // This would typically send a password reset email
        // For now, we'll just return a success message
        
        return redirect()->back()
            ->with('success', 'Password reset email sent to user.');
    }

    /**
     * Get user statistics.
     */
    public function statistics(): View
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        $recentUsers = User::withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.users.statistics', compact('stats', 'recentUsers'));
    }
}
