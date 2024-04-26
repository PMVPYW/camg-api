<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Resources\AdminResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::all();
        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
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

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, User $admin)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $admin, $request) {
            if ($request->hasFile("photo_url")) {
                if ($admin->photo_url && Storage::exists('public/fotos/' . $admin->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $admin->photo_url);
                }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        if (User::all()->count() == 1)
        {
            return response()->json(['message' => 'Você não pode eliminar todos os utilizadores!'], 401);
        }
        DB::transaction(function () use ($admin) {
            #hard delete
            if ($admin->photo_url && Storage::exists('public/fotos/' . $admin->photo_url)) {
                Storage::disk('public')->delete('fotos/' . $admin->photo_url);
            }
            $admin->tokens()->delete();
            $admin->delete();
        });
        return new AdminResource($admin);
    }

    public function toggle_blocked(User $admin)
    {
        if ($admin->id == Auth::user()->id)
        {
            return response()->json(['message' => 'Você não se pode bloquear a você próprio!'], 401);
        }
        if (!$admin->blocked && User::query()->where("blocked", false)->count() == 1)
        {
            return response()->json(['message' => 'Você não bloquear todos os utilizadores!'], 401);
        }
        $admin->blocked = !$admin->blocked;
        $admin->save();
        if ($admin->blocked)
        {
            $admin->tokens()->delete();
        }
        return new AdminResource($admin);
    }

    public function authorize_admin(User $admin)
    {
        $admin->authorized = true;
        $admin->save();
        return new AdminResource($admin);
    }
}
