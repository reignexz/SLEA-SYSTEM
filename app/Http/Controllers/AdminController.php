<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Make sure this is added

class AdminController extends Controller
{
    public function createAssessor()
    {
        // Generate the next password based on the latest user
        $lastUser = User::latest('id')->first();
        $nextId = $lastUser ? $lastUser->id + 1 : 1;
        $defaultPassword = 'AS' . $nextId . '_123';

        return view('admin.create_assessor', compact('defaultPassword'));
    }

    public function approveReject()
    {
        return view('admin.approve-reject');
    }

    public function submissionOversight()
    {
        // For now, return the view without data
        // Later you can add logic to fetch submissions from database
        return view('admin.submission-oversight');
    }

    public function finalReview()
    {
        // For now, return the view without data
        // Later you can add logic to fetch students for final review from database
        return view('admin.final-review');
    }

    public function awardReport()
    {
        // For now, return the view without data
        // Later you can add logic to fetch award report data from database
        return view('admin.award-report');
    }

    public function systemMonitoring()
    {
        // Placeholder view for system monitoring and logs
        return view('admin.system-monitoring');
    }

    /**
     * Manage Account – list, filter, sort, search
     */
    public function manageAccount(Request $request)
    {
        $q = User::query();

        // Search
        if ($term = $request->string('q')->toString()) {
            $q->where(function ($w) use ($term) {
                $w->where('email', 'like', "%{$term}%")
                  ->orWhere('name',  'like', "%{$term}%");
            });
        }

        // Filter
        if ($filter = $request->string('filter')->toString()) {
            match ($filter) {
                'active'   => $q->where('is_disabled', false),
                'disabled' => $q->where('is_disabled', true),
                'new'      => $q->where('created_at', '>=', now()->subDays(7)),
                default    => null,
            };
        }

        // Sort
        if ($sort = $request->string('sort')->toString()) {
            match ($sort) {
                'name'       => $q->orderBy('name'),
                'date'       => $q->orderByDesc('created_at'),
                'status'     => $q->orderBy('is_disabled'),
                'last_login' => $q->orderByDesc('last_login_at'),
                default      => $q->latest('created_at'),
            };
        } else {
            $q->latest('created_at');
        }

        $users = $q->paginate(12);

        // IMPORTANT: this returns the blade below
        return view('admin.manage-account', compact('users'));
    }

    /**
     * Toggle enable/disable
     */
    public function toggleUser(User $user)
    {
        $user->is_disabled = ! (bool) $user->is_disabled;
        $user->save();

        return back()->with('status', 'User status updated.');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        $user->delete();

        return back()->with('status', 'User deleted.');
    }
}