<?php

namespace App\Http\Controllers;

use App\Http\Requests\CopyProvaRequest;
use App\Http\Requests\ProvaFiltersRequest;
use App\Http\Requests\ProvaRequest;
use App\Http\Requests\ProvaUpdateRequest;
use App\Http\Resources\HorarioResource;
use App\Http\Resources\ProvaResource;
use App\Models\Prova;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProvaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProvaFiltersRequest $request)
    {
        $prova=Prova::query();
        /*if (!$request->order || $request->order == 'proximity') {
            $prova = $prova->orderByRaw("ABS(DATEDIFF(data_inicio, ?)) ASC", [today()]);
        }else */
        if ($request->order == 'nome_desc') {
            $prova = $prova->orderBy('nome', 'desc');
        } else if ($request->order == 'nome_asc') {
            $prova = $prova->orderBy('nome', 'asc');
        } else if ($request->order == 'local_desc') {
            $prova = $prova->orderBy('local', 'desc');
        } else if ($request->order == 'local_asc') {
            $prova = $prova->orderBy('local', 'asc');
        }else if ($request->order == 'distancia_percurso_asc') {
            $prova = $prova->orderBy('distancia_percurso', 'asc');
        } else if ($request->order == 'distancia_percurso_desc') {
            $prova = $prova->orderBy('distancia_percurso', 'desc');
        }


        if($request->rally_id){
            $prova->where([["rally_id", $request->rally_id]]);
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $prova = $prova->where('nome', 'LIKE', "%{$request->search}%")
                ->orWhere('local', 'LIKE', "%{$request->search}%");
        }
        return ProvaResource::collection($prova->get());
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
        DB::transaction(function() use ($request, $validated, $prova){
            if ($request->hasFile("kml_src")) {
                if ($prova->kml_src && Storage::exists('public/kml_files/' . $prova->kml_src)) {
                    Storage::disk('public')->delete('kml_files/' . $prova->kml_src);
                }
                $file = $request->file("kml_src");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('kml_files/' . $file_name_to_store, File::get($file));
                $prova->kml_src = $file_name_to_store;
            }
            unset($validated["kml_src"]);
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
        DB::transaction(function () use ($prova) {
        foreach ($prova->zonas_espetaculo as $ze)
        {
            $ze->forceDelete();
        }
        if ($prova->horario)
        {
            $prova->horario->forceDelete();
        }
            if ($prova->kml_src && Storage::exists('public/kml_files/' . $prova->kml_src)) {
                Storage::disk('public')->delete('kml_files/' . $prova->kml_src);
            }
            $prova->forceDelete();
        });
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

    public function getHorario(Prova $prova)
    {
        if ($prova->horario()->count() == 0)
        {
            return response()->json(['data' => null], 200);
        }
        return new HorarioResource($prova->horario);
    }
}
