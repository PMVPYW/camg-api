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
        $response = Http::get('https://rest3.anube.es/rallyrest/timing/api/specials/111.json');
        $posts = $response->json();
        $posts = $posts['event']['data']['itineraries'][0]['specials'][0];
        $validated= $request->validated();
        $prova = null;
        DB::transaction(function() use ($validated, &$prova, $posts)
        {
            $prova = new Prova();
            $prova->local = $posts["name_extra"];
            $prova->distancia_percurso = $posts["meters"];
            $prova->nome = $posts["special_name"];
            $prova->external_id = $posts["id"];
            $prova->rally_id = $validated["rally_id"];
            $prova->save();
        });
        return new ProvaResource($prova);
    }
}

//    protected $fillable = ["rally_id","external_id","local","distancia_percurso","data_inicio","nome"];
return [
    "data_inicio" => "sometimes|date",
    "rally_id" => "required | integer |exists:rallies,id",
    "external_id" => "required | integer",
    "local" => "required | string",
    "distancia_percurso" => "required | integer",
    "nome" => "required | string",
];
