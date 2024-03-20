<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(AuthenticationRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated))
        {
            $user = Auth::user();
            return response()->json(['message' => 'Logged in successfully', 'token' => $user->createToken('authToken')->plainTextToken], 200);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
