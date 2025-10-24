<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('user.index', compact('users'));
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'designation' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6',
            // 'image' => 'nullable|image|max:2048'
        ]);

        $userData = $request->only(['name', 'email', 'phone', 'designation']);
        $userData['password'] = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);

            $userData['image'] = 'uploads/users/' . $filename;
        }

        User::create($userData);

        return response()->json(['message' => 'User created successfully!']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'designation']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/users'), $filename);
            $data['image'] = 'uploads/users/' . $filename;
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully']);
    }
}
