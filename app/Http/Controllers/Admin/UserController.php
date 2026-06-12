<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create'); // Return your form view here
    }

    public function store(Request $request)
    {
        // 1. Validate the form payload
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_sales'   => ['required'],
        ]);
  
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_sales' => $validated['is_sales'],
        ]);

        
        return redirect()->route('admin.users.create')->with('success', 'User registered successfully!');
    }
}