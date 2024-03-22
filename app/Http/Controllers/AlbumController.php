<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Http\Resources\AlbumResource;
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
    public function index()
    {
        $albuns = Album::all();
        return AlbumResource::collection($albuns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $validated = $request->validated();
        $file_name_to_store = null;
        if ($request->hasFile("img"))
        {
            $file = $request->file("img");
            $file_type  = $file->getClientOriginalExtension();
            $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.'  .  $file_type;
            Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
        }
        $album = null;
        DB::transaction(function() use ($validated, &$album, $file_name_to_store)
        {
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
