<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AssessorController extends Controller
{
    /**
     * Display the assessor profile page.
     */
    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('assessor.profile', compact('user'));
    }

    /**
     * Update the assessor's profile information.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'position' => $request->position,
        ]);

        return redirect()->route('assessor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the assessor's password.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        // Additional password requirements validation
        $password = $request->new_password;
        $requirements = [
            'length' => strlen($password) >= 8,
            'uppercase' => preg_match('/[A-Z]/', $password),
            'lowercase' => preg_match('/[a-z]/', $password),
            'number' => preg_match('/\d/', $password),
            'special' => preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password),
        ];

        if (!$requirements['length'] || !$requirements['uppercase'] || 
            !$requirements['lowercase'] || !$requirements['number'] || 
            !$requirements['special']) {
            return redirect()->back()
                ->with('error', 'Password does not meet all requirements.');
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('assessor.profile')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Upload and update profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        /** @var User $user */
        $user = Auth::user();
        
        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Store the file in storage/app/public/profiles
            $path = $file->storeAs('public/profiles', $filename);
            
            // Update user profile picture path
            $user->update([
                'profile_picture' => 'profiles/' . $filename,
            ]);
        }

        return redirect()->route('assessor.profile')
            ->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Display the assessor dashboard.
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        // Add any dashboard-specific data here
        return view('assessor.dashboard', compact('user'));
    }


    /**
     * Display pending submissions.
     */
    public function pendingSubmissions()
    {
        /** @var User $user */
        $user = Auth::user();
        // Add logic to fetch pending submissions
        return view('assessor.pending-submissions', compact('user'));
    }

    /**
     * Display completed submissions.
     */
    public function submissions()
    {
        /** @var User $user */
        $user = Auth::user();
        // Add logic to fetch completed submissions
        return view('assessor.submissions', compact('user'));
    }

    /**
     * Display final review page.
     */
    public function finalReview()
    {
        /** @var User $user */
        $user = Auth::user();
        // Add logic for final review
        return view('assessor.final-review', compact('user'));
    }
}
