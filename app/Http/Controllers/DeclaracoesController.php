<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclaracaoRequest;
use App\Http\Requests\DeclaracaoUpdateRequest;
use App\Http\Resources\DeclaracaoResource;
use App\Models\Declaracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DeclaracoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DeclaracaoResource::collection(Declaracao::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeclaracaoRequest $request)
    {
        $validated= $request->validated();
        $declaracao = null;
        DB::transaction(function() use ($validated, &$declaracao, $request)
        {
            $declaracao = new Declaracao();
            if ($request->hasFile("photo_url")) {
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('declaracoes/' . $file_name_to_store, File::get($file));
                $declaracao->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $declaracao->fill($validated);
            $declaracao->save();
        });
        return response(new DeclaracaoResource($declaracao), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Declaracao $declaracao)
    {
        return new DeclaracaoResource($declaracao);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeclaracaoUpdateRequest $request, Declaracao $declaracao)
    {
        $validated=$request->validated();
        DB::transaction(function() use ($validated, &$declaracao, $request){
            if ($request->hasFile("photo_url")) {
                if ($declaracao->photo_url && Storage::exists('public/declaracoes/' . $declaracao->photo_url)) {
                    Storage::disk('public')->delete('declaracoes/' . $declaracao->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('declaracoes/' . $file_name_to_store, File::get($file));
                $declaracao->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $declaracao->fill($validated);
            $declaracao->save();
        });
        return new DeclaracaoResource($declaracao);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Declaracao $declaracao)
    {
        DB::transaction(function () use($declaracao){
            #hard delete
            if ($declaracao->photo_url && Storage::exists('public/declaracoes/' . $declaracao->photo_url)) {
                Storage::disk('public')->delete('declaracoes/' . $declaracao->photo_url);
            }
            $declaracao->forceDelete();
        });
        return new DeclaracaoResource($declaracao);
    }
}
