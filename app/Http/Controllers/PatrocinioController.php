<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatrocinioRequest;
use App\Http\Requests\PatrocinioRequestDelete;
use App\Http\Requests\PatrocinioRequestUpdate;
use App\Http\Resources\PatrocinioResource;
use App\Models\Entidade;
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
        $patrocinios = Patrocinio::query();
        $patrocinios = $patrocinios->where("entidade_oficial",false)->orderBy('relevancia', 'desc');
        return PatrocinioResource::collection($patrocinios->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatrocinioRequest $request)
    {
        $validated= $request->validated();
        $patrocinio = null;
        $entidade = Entidade::findOrFail($request->entidade_id);
        DB::transaction(function() use ($validated, &$patrocinio, $request, $entidade)
        {
            if($entidade->entidade_oficial==$request->entidade_oficial){
                $patrocinio = new Patrocinio();
                $patrocinio->fill($validated);
                $patrocinio->save();
            }
        });
        return !($entidade->entidade_oficial==$request->entidade_oficial) ? response()->json(["Error"=> "A associação entre o patrocinio e a entidade não é válida"], 522) : response(new PatrocinioResource($patrocinio), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patrocinio $patrocinio)
    {
        if($patrocinio->entidade_oficial === 0){
            return new PatrocinioResource($patrocinio);
        }else{
            return response()->json(["Error"=> "A Entidade é oficial"], 522);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatrocinioRequestUpdate $request, Patrocinio $patrocinio)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$patrocinio)
        {
            $patrocinio->fill($validated);
            $patrocinio->save();
        });
        return new PatrocinioResource($patrocinio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patrocinio $patrocinio)
    {
        $patrocinio->forceDelete();
        return new PatrocinioResource($patrocinio);
    }


    //Patrocinios Oficiais(Index e Show)

    public function patrocinioOficial(){
        $patrocinios = Patrocinio::query();
        $patrocinios = $patrocinios->where('entidade_oficial', true);
        return PatrocinioResource::collection($patrocinios->get());
    }

    public function showPatrocinioOficial(Patrocinio $patrocinioOficial)
    {
        if($patrocinioOficial->entidade_oficial === 1){
            return new PatrocinioResource($patrocinioOficial);
        }else{
            return response()->json(["Error"=> "A Entidade não é oficial"], 522);
        }
    }



    //Métodos Auxiliares
    public function destroyAllSponsors(PatrocinioRequestDelete $patrocinios)
    {
        $deleted_sponsors=[];
        DB::transaction(function () use($patrocinios, &$deleted_sponsors){
            $patrociniosIds = $patrocinios->input('patrocinios_id', []);
            if (!empty($patrociniosIds)) {
                foreach ($patrociniosIds as $patrociniosId) {
                    $patrocinio = Patrocinio::find($patrociniosId);
                    $deleted_sponsors[]=$patrocinio;
                    $patrocinio->forceDelete();
                }
            }
        });
        return PatrocinioResource::collection($deleted_sponsors);
    }

}
