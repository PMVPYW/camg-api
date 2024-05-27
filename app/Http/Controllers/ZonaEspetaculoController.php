<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZonaEspetaculoRequest;
use App\Http\Requests\ZonaEspetaculoUpdateRequest;
use App\Http\Resources\ZonaEspetaculoResource;
use App\Models\ZonaEspetaculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZonaEspetaculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ZonaEspetaculoResource::collection(ZonaEspetaculo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ZonaEspetaculoRequest $request)
    {
        $validated = $request->validated();
        $zonaEspetaculo = new ZonaEspetaculo();
        DB::transaction(function () use ($validated, &$zonaEspetaculo) {
            $zonaEspetaculo->fill($validated);
            $zonaEspetaculo->save();
        });
        return new ZonaEspetaculoResource($zonaEspetaculo);
    }

    /**
     * Display the specified resource.
     */
    public function show(ZonaEspetaculo $zonaEspetaculo)
    {
        return new ZonaEspetaculoResource($zonaEspetaculo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ZonaEspetaculoUpdateRequest $request, ZonaEspetaculo $zonaEspetaculo)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $zonaEspetaculo) {
            $zonaEspetaculo->fill($validated);
            $zonaEspetaculo->save();
        });
        return new ZonaEspetaculoResource($zonaEspetaculo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZonaEspetaculo $zonaEspetaculo)
    {
        $zonaEspetaculo->forceDelete();
    }
}
