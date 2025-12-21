<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json([
                'success' => false,
                'message' => 'invalid email or password',
            ], 401);

        $user = User::where('email', $request->email)->first();
        // delete old tokens
        $user->tokens()->delete();

        // create token
        $token = $user->createToken('api_Token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            'User' => $user,
            'Token' => $token,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Successfully',
        ]);
    }

    public function me(Request $request){
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }
}
