<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user exists in the database
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // User not found, redirect back with error message
            return redirect()->back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->withInput($request->only('email')); // Keep email input value
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/');
        }

        // Authentication failed (password incorrect), redirect back with error message
        return redirect()->back()->withErrors([
            'password' => 'The password you entered is incorrect.',
        ])->withInput($request->only('email')); // Keep email input value
    }

}
