<?php

namespace App\Http\Controllers;

use App\Http\Requests\RallyRequest;
use App\Http\Requests\RallyRequestUpdate;
use App\Http\Resources\RallyResource;
use App\Models\Rally;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RallyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rallies = Rally::all();
        return RallyResource::collection($rallies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RallyRequest $request)
    {
        $validated = $request->validated();
        $rally = null;
        DB::transaction(function() use ($validated, &$rally)
        {
            $rally = new Rally();
            $rally->fill($validated);
            $rally->save();
        });
        return new RallyResource($rally);
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
        DB::transaction(function() use ($validated, $rally)
        {
            $rally->fill($validated);
            $rally->save();
        });
        return new RallyResource($rally);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
