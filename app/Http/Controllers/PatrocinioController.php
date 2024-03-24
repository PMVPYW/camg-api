<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatrocinioRequest;
use App\Http\Requests\PatrocinioRequestUpdate;
use App\Http\Resources\PatrocinioResource;
use App\Models\Patrocinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatrocinioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patrocinios = Patrocinio::all();
        return PatrocinioResource::collection($patrocinios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatrocinioRequest $request)
    {
        $validated= $request->validated();
        $patrocinio = null;
        DB::transaction(function() use ($validated, &$patrocinio)
        {
            $patrocinio = new Patrocinio();
            $patrocinio->fill($validated);
            $patrocinio->save();
        });

        return response()->json(["message"=>"Patrocianio created $patrocinio"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patrocinio $patrocinio)
    {
        return new PatrocinioResource($patrocinio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatrocinioRequestUpdate $request, Patrocinio $patrocinio)
    {
        $validated=$request->validated();
        $patrocinio=null;
        DB::transaction(function() use ($validated, &$patrocinio){
            $patrocinio->fill($validated);
            $patrocinio->save();
        });
        return response()->json(["message"=>"Patrocianio updated $patrocinio"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patrocinio $patrocinio)
    {
        $patrocinio->forceDelete();
        return response()->json(["Patrocinio deleted"], 200);
    }
}
