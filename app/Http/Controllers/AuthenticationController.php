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
            if ($user->blocked)
            {
                return response()->json(['message' => 'O seu utilizador encontra-se bloqueado. Por Favor contacte um administrador!'], 401);
            }
            if (!$user->authorized){
                return response()->json(['message' => 'O seu utilizador ainda não foi autorizado, por Favor contacte um administrador!'], 401);
            }
            return response()->json(['message' => 'Logged in successfully', 'token' => $user->createToken('authToken')->plainTextToken], 200);
        }
        return response()->json(['message' => 'Credenciais Inválidas!'], 401);
    }
}
