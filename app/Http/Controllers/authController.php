<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user,
        'token' => $token,
    ]);
}

   
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'], 
            'password' => ['required']
        ]);

        
        $user = User::where('email', $credentials['email'])->first();
        
      
        if (!$user) {
            return response()->json(['message' => 'You don’t have an account!'], 401);
        }

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthenticated -_-'], 401);
    }

    public function logout(Request $request)
    {
     
        $request->user('user')->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful']);
    }

    public function profile(Request $request)
    {
        
        return response()->json(['data' => $request->user('user')]);
    }


    

}
