<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Resources\AdminResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function register(AdminRequest $request)
    {
        $validated = $request->validated();
        $admin = null;
        DB::transaction(function () use ($validated, &$admin, $request) {
            $admin = new User();
            if ($request->hasFile("photo_url")) {
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $admin->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $admin->fill($validated);
            $admin->save();
        });
        return new AdminResource($admin);
    }
}
