<?php

namespace App\Http\Controllers\Client\Auth;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client_panel.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'phone_number' => 'required',
            'code' => 'required',
        ]);

        // Retrieve the client based on the phone number (assuming 'mobile' is the phone number field)
        $client = Client::where('mobile', $request->phone_number)->first();

        // Check if client exists and the code matches
        if ($client && $client->code == $request->code) {
            // Attempt to login the client
            Auth::guard('client')->login($client);

            // Redirect to client panel or intended URL
            return redirect()->route('client.index'); // Adjust this route as per your application logic
        } else {
            // Client not found or code doesn't match, redirect back with error message
            return redirect()->back()->withErrors([
                'code' => 'Invalid credentials.',
            ])->withInput($request->only('phone_number'));
        } 
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
