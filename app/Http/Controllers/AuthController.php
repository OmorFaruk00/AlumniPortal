<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $token = Str::random(120);

        $user->api_token = $token;
        $user->token_expires_at = Carbon::now()->addHours(2);
        $user->save();
        Session::put('token', $token);
        Session::put('user', $user);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $user = session('user');
        if ($user) {
            $user = User::find($user->id);
            if ($user) {
                $user->api_token = null;
                $user->token_expires_at = null;
                $user->save();
            }
        }
        session()->forget('token');
        session()->forget('user');
        session()->flush();

        return redirect('/');
    }
}
