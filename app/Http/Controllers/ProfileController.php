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
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',  // each tag name is string max 50 chars
        ];

        if ($request->filled('password')) {
            $rules['current_password'] = ['required'];
            $rules['password'] = ['required', 'confirmed', 'min:6']; 
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
            $user->password = bcrypt($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? $user->bio;
        $user->user_type = $validated['user_type'];
        $user->category_id = $validated['category_id'] ?? null;


        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $user->logo = $logoPath;
        }

        $user->save();

        // Handle tags syncing
        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $user->tags()->sync($tagIds);
        } else {
            // If no tags sent, detach all tags
            $user->tags()->detach();
        }
        

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

}
