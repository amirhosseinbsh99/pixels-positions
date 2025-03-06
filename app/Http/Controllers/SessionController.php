<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }
    public function store(){
        //validate
        $ValidatedAttributes = request()->validate([
            'email' => ['required','email'],
            'password' => ['required']
            ]);
        //attempt to log
        if(! Auth::attempt($ValidatedAttributes)){
            throw ValidationException::withMessages([
                'email' => 'sorry, email is wrong.'
            ]);
            }
        //regenerate the session token
        request()->session()->regenerate();
        //redirect
        return redirect('/');
    }
    public function destroy(){
        Auth::logout();

        return redirect('/');
    }
}
