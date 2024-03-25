<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConcelhoSegurancaResource;
use App\Models\ConcelhoSeguranca;
use Illuminate\Http\Request;

class ConcelhoSegurancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ConcelhoSegurancaResource::collection(ConcelhoSeguranca::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ConcelhoSeguranca $conselhoSeguranca)
    {
        if($conselhoSeguranca->id == null) {
            return response()->json(["message" => "entity not found"], 404);
        }
        return new ConcelhoSegurancaResource($conselhoSeguranca);
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
