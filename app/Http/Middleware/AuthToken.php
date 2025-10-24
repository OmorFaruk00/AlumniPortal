<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthToken
{

    public function handle(Request $request, Closure $next)
    {
        $token = $request->query('token');
        if (!$token) {
            return response()->json(['message' => 'Token missing'], 401);
        }

        $user = User::where('api_token', $token)
            ->where('token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }
        auth()->setUser($user);

        return $next($request);
    }
}
