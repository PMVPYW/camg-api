<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapituloRequest;
use App\Http\Requests\CapituloUpdateRequest;
use App\Http\Resources\CapituloResource;
use App\Models\Capitulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CapituloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Capitulo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CapituloRequest $request)
    {
        $validated= $request->validated();
        $capitulo = null;
        DB::transaction(function() use ($validated, &$capitulo)
        {
            $capitulo = new Capitulo();
            $capitulo->fill($validated);
            $capitulo->save();
        });
        return response(new CapituloResource($capitulo), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Capitulo $capitulo)
    {
        return new CapituloResource($capitulo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CapituloUpdateRequest $request, Capitulo $capitulo)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$capitulo)
        {
            $capitulo->fill($validated);
            $capitulo->save();
        });
        return new CapituloResource($capitulo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capitulo $capitulo)
    {
        DB::transaction(function () use ($capitulo) {
            foreach ($capitulo->etapas as $etapa){
                $etapa->forceDelete();
            }
            $capitulo->forceDelete();
        });
        return new CapituloResource($capitulo);
    }
}
