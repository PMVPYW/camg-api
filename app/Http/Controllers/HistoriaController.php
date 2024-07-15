<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaRequest;
use App\Http\Requests\HistoriaUpdateRequest;
use App\Http\Resources\HistoriaResource;
use App\Models\Etapa;
use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HistoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HistoriaResource::collection(Historia::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoriaRequest $request)
    {
        $validated= $request->validated();
        $historia = null;
        DB::transaction(function() use ($validated, &$historia, $request)
        {
            $historia = new Historia();
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();
        });
        return response(new HistoriaResource($historia), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Historia $historia)
    {
        return new HistoriaResource($historia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HistoriaUpdateRequest $request, Historia $historia)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$historia, $request)
        {
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();
        });
        return new HistoriaResource($historia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historia $historia)
    {
        DB::transaction(function () use ($historia) {
            foreach ($historia->capitulos as $capitulo) {
                foreach ($capitulo->etapas as $etapa){
                    $etapa->forceDelete();
                }
                $capitulo->forceDelete();
            }
            $historia->forceDelete();
        });
        return new HistoriaResource($historia);
    }
}
