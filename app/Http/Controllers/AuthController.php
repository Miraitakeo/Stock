<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Hardcoded admin user (replace with database check in production)
        $adminUser = [
            'email' => 'admin@stockcontrol.com',
            'password' => 'SecurePassword123!',
            'name' => 'System Administrator'
        ];

        if ($request->email === $adminUser['email'] && 
            $request->password === $adminUser['password']) {
            $request->session()->put('authenticated', true);
            $request->session()->put('user', $adminUser);
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}