<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConselhoSegurancaRequest;
use App\Http\Resources\ConselhoSegurancaResource;
use App\Models\ConselhoSeguranca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConselhoSegurancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ConselhoSegurancaResource::collection(ConselhoSeguranca::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConselhoSegurancaRequest $request)
    {
        $validated = $request->validated();
        //img1 - img_conselho
        $file = $request->file("img_conselho");
        $file_type = $file->getClientOriginalExtension();
        $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
        Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
        //img2 - img_erro
        $file = $request->file("img_erro");
        $file_type = $file->getClientOriginalExtension();
        $file_name_to_store2 = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
        Storage::disk('public')->put('fotos/' . $file_name_to_store2, File::get($file));

        $conselho = null;
        DB::transaction(function () use ($validated, &$conselho, $file_name_to_store, $file_name_to_store2) {
            $conselho = new ConselhoSeguranca();
            $conselho->fill($validated);
            $conselho->img_conselho = $file_name_to_store;
            $conselho->img_erro = $file_name_to_store2;
            $conselho->save();
        });
        return new ConselhoSegurancaResource($conselho);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConselhoSeguranca $conselhoSeguranca)
    {
        if($conselhoSeguranca->id == null) {
            return response()->json(["message" => "entity not found"], 404);
        }
        return new ConselhoSegurancaResource($conselhoSeguranca);
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
