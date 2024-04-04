<?php

namespace App\Http\Controllers;

use App\Http\Requests\RallyRequest;
use App\Http\Requests\RallyRequestUpdate;
use App\Http\Resources\EntidadeResource;
use App\Http\Resources\PatrocinioResource;
use App\Http\Resources\RallyResource;
use App\Models\Rally;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RallyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rallies = Rally::query();
        if (!$request->order || $request->order == 'proximity') {
            $rallies = $rallies->orderByRaw("ABS(DATEDIFF(data_inicio, ?)) ASC", [today()]);
        } elseif ($request->order == 'date_desc') {
            $rallies = $rallies->orderBy('data_inicio', 'desc');
        } elseif ($request->order == 'date_asc') {
            $rallies = $rallies->orderBy('data_inicio', 'asc');
        }

        if ($request->data_inicio)
        {
            $rallies = $rallies->where("data_inicio", ">=", $request->data_inicio);
        }
        //dd($request->all());
        if ($request->data_fim)
        {
            $rallies = $rallies->where("data_inicio", "<=", $request->data_fim);
        }

        return RallyResource::collection($rallies->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RallyRequest $request)
    {
        $validated = $request->validated();
        $rally = null;
        DB::transaction(function () use ($validated, &$rally, $request) {
            $rally = new Rally();
            if ($request->hasFile("photo_url")) {
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $rally->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $rally->fill($validated);
            $rally->save();
        });
        return response(new RallyResource($rally), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rally = Rally::findOrFail($id);
        return new RallyResource($rally);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RallyRequestUpdate $request, Rally $rally)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $rally, $request) {
            if ($request->hasFile("photo_url")) {
                if ($rally->photo_url && Storage::exists('public/fotos/' . $rally->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $rally->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $rally->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $rally->fill($validated);
            $rally->save();
        });
        return new RallyResource($rally);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rally $rally)
    {
        DB::transaction(function () use ($rally) {
            if ($rally->noticias()->count() + $rally->Albuns()->count() == 0) {
                #hard delete
                if ($rally->photo_url && Storage::exists('public/fotos/' . $rally->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $rally->photo_url);
                }
                $rally->forceDelete();
            } else {
                #soft delete
                $rally->delete();
            }

        });
        return new RallyResource($rally);
    }

    public function getPatrocinios(Rally $rally)
    {
        return PatrocinioResource::collection($rally->patrocinios);
    }
}
