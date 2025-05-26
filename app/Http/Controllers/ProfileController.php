<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('edit-profile');
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:2048',
            'user_type' => 'required|in:jobseeker,employer',
        ];

        // If user is trying to change password
        if ($request->filled('password')) {
            $rules['current_password'] = ['required'];
            $rules['password'] = ['required', 'confirmed', 'min:6']; 
        }

        $validated = $request->validate($rules);

        // If password change requested, verify current password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
            // update password
            $user->password = bcrypt($request->password);
        }

        // Update other fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? $user->bio;
        $user->user_type = $validated['user_type'];

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $user->logo = $logoPath;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

}
