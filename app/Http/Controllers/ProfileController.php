<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function chnagePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::user()->id);
        // Check old password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current Password Invalid'], 401);
        }
        // Update new password
        $user->password = Hash::make($request->password);
        $user->update();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Password Change Successfully'], 200);
    }
}
