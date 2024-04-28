<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminsFiltersRequest;
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
    public function index(AdminsFiltersRequest $request)
    {
        $validated_data = $request->validated();
        $admins = User::query();
        if (!$request->order || $request->order == "most_recent") {
            $admins = $admins->orderBy('created_at', 'desc');
        } else if ($request->order == 'least_recent') {
            $admins = $admins->orderBy('created_at', 'asc');
        } else if ($request->order == 'nome_asc') {
            $admins = $admins->orderBy('nome', 'asc');
        } else if ($request->order == 'nome_desc') {
            $admins = $admins->orderBy('nome', 'desc');
        }

        //if (!$request->status || $request->status == "all") //nothing to do here
        if ($request->status == "unblocked") {
            $admins = $admins->where('blocked', '=', 0)->where("authorized", "=", 1);
        } else if ($request->status == "blocked") {
            $admins = $admins->where('blocked', '=', 1)->where("authorized", "=", 1);
        } else if ($request->status == "unauthorized") {
            $admins = $admins->where("authorized", "=", 0);
        }

        if ($request->search)
        {
            $admins = $admins->where("nome", 'like', "%$request->search%")->orWhere("email", 'like', "%$request->search%");
        }
        return AdminResource::collection($admins->paginate(15));
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
        $can_log = User::where('blocked', 0)->where('authorized', 1);
        if ($can_log->count() == 1 && $can_log->where('id', $admin->id)->count() == 1) {
            return response()->json(['message' => 'Você não pode eliminar todos os utilizadores que conseguem iniciar sessão!'], 401);
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
        if ($admin->id == Auth::user()->id) {
            return response()->json(['message' => 'Você não se pode bloquear a você próprio!'], 401);
        }
        if (!$admin->blocked && User::query()->where("blocked", false)->count() == 1) {
            return response()->json(['message' => 'Você não bloquear todos os utilizadores!'], 401);
        }
        $admin->blocked = !$admin->blocked;
        $admin->save();
        if ($admin->blocked) {
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
