<?php

namespace App\Http\Controllers;

use App\Http\Requests\EtapaRequest;
use App\Http\Requests\EtapaUpdateRequest;
use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Etapa::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EtapaRequest $request)
    {
        $validated= $request->validated();
        $etapa = null;
        DB::transaction(function() use ($validated, &$etapa)
        {
            $etapa = new Etapa();
            $etapa->fill($validated);
            $etapa->save();
        });
        return response($etapa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etapa $etapa)
    {
        return $etapa;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EtapaUpdateRequest $request, Etapa $etapa)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$etapa)
        {
            $etapa->fill($validated);
            $etapa->save();
        });
        return $etapa;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etapa $etapa)
    {
        return $etapa;
    }
}
