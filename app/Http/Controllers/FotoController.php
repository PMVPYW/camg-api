<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoRequest;
use App\Http\Requests\FotoUpdateRequest;
use App\Http\Resources\FotoResource;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FotoResource::collection(Foto::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FotoRequest $request)
    {
        $fotos = [];
        $validated = $request->validated();
        unset($validated["image_src"]);
        foreach ($request->file("image_src") as $file) {
            $file_type = $file->getClientOriginalExtension();
            $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
            Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
            $foto = null;
            DB::transaction(function () use ($validated, &$foto, $file_name_to_store) {
                $foto = new Foto();
                $foto->fill($validated);
                $foto->image_src = $file_name_to_store;
                $foto->save();
            });
            array_push($fotos, $foto);
        }

        return FotoResource::collection($fotos);
    }

    /**
     * Display the specified resource.
     */
    public function show(Foto $foto)
    {
        return new FotoResource($foto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FotoUpdateRequest $request, Foto $foto)
    {
        $validated = $request->validated();
        if ($request->hasFile("image_src"))
        {
            if (Storage::exists("public/fotos/" . $foto->image_src))
            {
                $file = $request->file("image_src");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
            }
            unset($validated["image_src"]);
        }
        if (!isset($validated["description"]))
        {
            $foto->description = null;
        }
        $foto->fill($validated);
        $foto->save();
        return new FotoResource($foto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foto $foto)
    {
        DB::transaction(function () use ($foto) {
           if ($foto->ImagemNoticia()->count() == 0)
           {
               $foto->forceDelete();
           } else {
               $foto->delete();
           }
        });
        return new FotoResource($foto);
    }
}
