<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectToApps
{
    public function handle(Request $request, Closure $next)
    {
        // Must be logged in
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You must login first.');
        }

        // Must have token in session
        $token = Session::get('token');
        if (!$token) {
            return redirect('/');
        }

        return $next($request);
    }
}

