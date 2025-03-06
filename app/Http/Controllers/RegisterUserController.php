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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userattributes = $request->validate([
            'name' => ['required'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed',Password::min(6)]
        ]);
        $employerattributes = $request->validate([
            'employer' => ['required'],
            'logo' => ['required',File::types(['png','jpg','webp'])]
        ]);
        $user = User::create($userattributes);

        $logoPath = $request->logo->store('logos');

        $user->employer()->create([
            'name' => $employerattributes['employer'],
            'logo' => $logoPath,
        ]);

        Auth::login($user);

        return redirect('/');
    }

}