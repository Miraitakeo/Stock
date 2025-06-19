<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.static-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',  // Changed from 'username' to 'email' to match your view
            'password' => 'required',
        ]);

        // Hardcoded credentials (match these with your login form)
        $validCredentials = [
            'email' => 'admin@example.com',  // Changed to match email format
            'password' => 'password'
        ];

        if (
            $request->email === $validCredentials['email'] &&
            $request->password === $validCredentials['password']
        ) {
            $request->session()->put('logged_in', true);  // Changed to match your route middleware
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',  // Changed to match field name
        ])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();  // Changed to match your route handler
        return redirect()->route('login');  // Changed to match your route name
    }
}