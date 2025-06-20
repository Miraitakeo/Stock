<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('authenticated')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
