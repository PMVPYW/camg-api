<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvaRequest;
use App\Http\Requests\ProvaUpdateRequest;
use App\Http\Resources\ProvaResource;
use App\Models\Prova;
use Illuminate\Support\Facades\Http;

class ProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProvaResource::collection(Prova::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProvaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Prova $prova)
    {
        return new ProvaResource($prova);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProvaUpdateRequest $request, Prova $prova)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prova $prova)
    {
        //
    }

    public function copyProvas()
    {
        $response = Http::get('https://rest3.anube.es/rallyrest/timing/api/specials/111.json');
        $posts = $response->json();
        dd($posts['event']['data']['itineraries'][0]['specials']);
    }
}
