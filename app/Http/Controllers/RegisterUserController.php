<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');

    }

    
    public function store(Request $request)
{
    $attributes = $request->validate([
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', Password::min(6)],
        'logo' => ['required', File::types(['png', 'jpg', 'webp'])],
        'user_type' => ['required'], // assuming it's a string like "employer" or "job_seeker"
        'bio' => ['nullable', 'string'],
    ]);

    // Store the logo
    $logoPath = $request->file('logo')->store('logos');
    $attributes['logo'] = $logoPath;

    // Hash the password before saving
    $attributes['password'] = bcrypt($attributes['password']);

    // Create the user
    $user = User::create($attributes);

    // Log the user in
    Auth::login($user);

    return redirect('/');
}

}