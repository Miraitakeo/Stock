<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !$user->is_admin || !Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors(['email' => 'Invalid admin credentials'])->onlyInput('email');
    }

    $request->session()->put('authenticated', true);
    $request->session()->put('user', [
        'id' => $user->id,
        'email' => $user->email,
        'name' => $user->name,
    ]);

    return redirect()->route('dashboard');
}

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
