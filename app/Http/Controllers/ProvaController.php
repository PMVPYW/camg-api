<?php

namespace App\Http\Controllers;

use App\Http\Requests\CopyProvaRequest;
use App\Http\Requests\ProvaRequest;
use App\Http\Requests\ProvaUpdateRequest;
use App\Http\Resources\ProvaResource;
use App\Models\Prova;
use Illuminate\Support\Facades\DB;
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
        $validated= $request->validated();
        $prova = null;
        DB::transaction(function() use ($validated, &$prova)
        {
            $prova = new Prova();
            $prova->fill($validated);
            $prova->save();
        });
        return response(new ProvaResource($prova), 201);
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
        $validated=$request->validated();
        DB::transaction(function() use ($validated, $prova){
            $prova->fill($validated);
            $prova->save();
        });
        return new ProvaResource($prova);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prova $prova)
    {
        $prova->forceDelete();
        return new ProvaResource($prova);
    }

    public function copyProvas(CopyProvaRequest $request)
    {
        $validated = $request->validated();
        $response = Http::get('https://rest3.anube.es/rallyrest/timing/api/specials/'.$validated["external_entity_id"].'.json');
        $posts = $response->json();
        $posts = $posts['event']['data']['itineraries'][0]['specials'];
        $provas = [];
        DB::transaction(function () use ($validated, &$provas, $posts) {
            foreach ($posts as $post) {
                $Prova = Prova::query();
                $n_provas_existentes=$Prova->where([["external_id", $post["id"]]])->first();
                if(!$n_provas_existentes){
                    $prova = new Prova();
                    $prova->local = $post["name_extra"];
                    $prova->distancia_percurso = $post["meters"];
                    $prova->nome = $post["special_name"];
                    $prova->external_id = $post["id"];
                    $prova->rally_id = $validated["rally_id"];
                    $provas[]=$prova;
                    $prova->save();
                }
            }
        });
        return ProvaResource::collection($provas);
    }
}
