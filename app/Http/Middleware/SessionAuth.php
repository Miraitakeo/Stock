<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if session key 'logged_in' is true
        if (!$request->session()->get('logged_in')) {
            // Not logged in, redirect to login page
            return redirect()->route('login');
        }

        // Proceed with the request
        return $next($request);
    }
}