<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // ← ADD THIS LINE
use App\Models\User;
use App\Notifications\UserProfileUpdated;
use Illuminate\Support\Facades\Notification;

class ProfileController extends Controller
{
    // Show edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:20',
            'household' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Handle profile picture removal
        if ($request->has('remove_profile_picture') && $user->profile_picture) {
            // Delete from storage
            if (Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $validated['profile_picture'] = null;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    // Add this method for standalone profile picture deletion
    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::user();
        
        if ($user->profile_picture) {
            // Delete the file from storage
            if (Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Remove the profile picture from database
            $user->profile_picture = null;
            $user->save();
            
            return redirect()->back()->with('success', 'Profile picture deleted successfully.');
        }
        
        return redirect()->back()->with('error', 'No profile picture to delete.');
    }
}