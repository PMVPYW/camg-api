<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumFiltersRequest;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumRequestUpdate;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\FotoResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AlbumFiltersRequest $request)
    {
        $validated = $request->validated(); //data is validated now - i will use request from here because i prefer the sintax
        $albuns = Album::query();
        if ($request->rally_id)
        {
            $rally_id = $request->rally_id;
            //if ($rally_id == "todos") -> n faz nada pq já vêm todos
            switch ($rally_id)
            {
                case "todos":
                    //continua igual
                    break;
                case "nenhum":
                    $albuns = $albuns->where('rally_id', null);
                    break;
                default:
                    $albuns = $albuns->where('rally_id', $rally_id);
            }

        }

        if ($request->search)
        {
            $albuns = $albuns->where("nome", "LIKE", "%{$request->search}%");
        }
        return AlbumResource::collection($albuns->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $validated = $request->validated();
        $file_name_to_store = null;
        if ($request->hasFile("img")) {
            $file = $request->file("img");
            $file_type = $file->getClientOriginalExtension();
            $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
            Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
        }
        $album = null;
        DB::transaction(function () use ($validated, &$album, $file_name_to_store) {
            $album = new Album();
            $album->fill($validated);
            $album->img = $file_name_to_store;
            $album->save();
        });
        return response(new AlbumResource($album), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return new AlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlbumRequestUpdate $request, Album $album)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($album, $request, $validated) {
            if ($request->hasFile("img")) {
                if ($album->img && Storage::exists('public/fotos/' . $album->img)) {
                    Storage::disk('public')->delete('fotos/' . $album->img);
                }
                $file = $request->file("img");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $album->img = $file_name_to_store;
            }
            unset($validated["img"]);
            $album->fill($validated);
            if (!$request->rally_id)
            {
                $album->rally_id = null;
            }
            $album->save();
        });
        return new AlbumResource($album);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {

        DB::transaction(function () use ($album) {
            if ($album->Photos->count() == 0) {
                if ($album->img && Storage::exists('public/fotos/' . $album->img)) {
                    Storage::disk('public')->delete('fotos/' . $album->img);
                }
                $album->forceDelete();
            } else {
                $album->delete();
            }
        });
        return new AlbumResource($album);
    }

    public function getFotos(Album $album)
    {
        return FotoResource::collection($album->Photos);
    }
}
