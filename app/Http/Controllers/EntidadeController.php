<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntidadeRequest;
use App\Http\Requests\EntidadeRequestUpdate;
use App\Http\Resources\EntidadeResource;
use App\Models\Entidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entidades = Entidade::all();
        return EntidadeResource::collection($entidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntidadeRequest $request)
    {
        $validated=$request->validated();
        $entidade=null;
        DB::transaction(function () use ($validated, &$entidade){
            $entidade=new Entidade();
            $entidade->fill($validated);
            $entidade->save();
        });
        return response(new EntidadeResource($entidade), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Entidade $entidade)
    {
        return EntidadeResource::collection($entidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntidadeRequestUpdate $request, Entidade $entidade)
    {
        $validated = $request->validated();
        DB::transaction(function() use ($validated, &$entidade){
            $entidade->fill($validated);
            $entidade->save();
        });

        return EntidadeResource::collection($entidade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entidade $entidade)
    {
        $entidade->delete();
        return EntidadeResource::collection($entidade);
    }
}
