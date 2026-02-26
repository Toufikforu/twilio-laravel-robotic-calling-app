<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    // User Profile
    public function profile()
    {
        $user = Auth::user(); // Get authenticated user
        return view('user.pages.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ensure user is authenticated

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Assign new values
        $user->name = $request->name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
