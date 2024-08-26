<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConselhoSegurancaRequest;
use App\Http\Requests\ConselhoSegurancaUpdateRequest;
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
        $file_name_to_store = str_replace('=', '', base64_encode(microtime()));
        while(Storage::disk('public')->exists('fotos/'.$file_name_to_store . '.' . $file_type))
        {
            $file_name_to_store = $file_name_to_store . random_int();
        }
        $file_name_to_store = $file_name_to_store . '.' . $file_type;
        Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
        //img2 - img_erro
        $file2 = $request->file("img_erro");
        $file_type2 = $file2->getClientOriginalExtension();
        $file_name_to_store2 = str_replace('=', '', base64_encode(microtime()));
        while(Storage::disk('public')->exists('fotos/'.$file_name_to_store2 . '.' . $file_type2))
        {
            $file_name_to_store2 = $file_name_to_store2 . random_int();
        }
        $file_name_to_store2 = $file_name_to_store2 . '.' . $file_type2;
        Storage::disk('public')->put('fotos/' . $file_name_to_store2, File::get($file2));

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
    public function show(string $id)
    {
        $conselhoSeguranca = ConselhoSeguranca::findOrFail($id);

        return new ConselhoSegurancaResource($conselhoSeguranca);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConselhoSegurancaUpdateRequest $request, string $id)
    {
        $conselho = ConselhoSeguranca::findOrFail($id);
        $validated = $request->validated();
        $file_name_to_store = $conselho->img_conselho;
        $file_name_to_store2 = $conselho->img_erro;
        //img1 - img_conselho
        if ($request->hasFile("img_conselho")) {
            if ($conselho->img_conselho && Storage::exists('public/fotos/' . $conselho->img_conselho)) {
                Storage::disk('public')->delete('fotos/' . $conselho->img_conselho);
            }
            $file = $request->file("img_conselho");
            $file_type = $file->getClientOriginalExtension();
            $file_name_to_store = str_replace('=', '', base64_encode(microtime()));
            while(Storage::disk('public')->exists('fotos/'.$file_name_to_store . '.' . $file_type))
            {
                $file_name_to_store = $file_name_to_store . random_int();
            }
            $file_name_to_store = $file_name_to_store . '.' . $file_type;
            Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
            unset($validated["img_conselho"]);
        }
        //img2 - img_erro
        if ($request->hasFile("img_erro")) {
            if ($conselho->img_erro && Storage::exists('public/fotos/' . $conselho->img_erro)) {
                Storage::disk('public')->delete('fotos/' . $conselho->img_erro);
            }
            $file2 = $request->file("img_erro");
            $file_type2 = $file2->getClientOriginalExtension();
            $file_name_to_store2 = str_replace('=', '', base64_encode(microtime()));
            while(Storage::disk('public')->exists('fotos/'.$file_name_to_store2 . '.' . $file_type2))
            {
                $file_name_to_store2 = $file_name_to_store2 . random_int();
            }
            $file_name_to_store2 = $file_name_to_store2 . '.' . $file_type2;
            Storage::disk('public')->put('fotos/' . $file_name_to_store2, File::get($file2));
            unset($validated["img_erro"]);
        }

        DB::transaction(function () use ($validated, &$conselho, $file_name_to_store, $file_name_to_store2) {
            $conselho->fill($validated);
            $conselho->img_conselho = $file_name_to_store;
            $conselho->img_erro = $file_name_to_store2;
            $conselho->save();
        });
        return new ConselhoSegurancaResource($conselho);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $conselhoSeguranca = ConselhoSeguranca::findOrFail($id);
        DB::transaction(function () use ($conselhoSeguranca) {
            if ($conselhoSeguranca->img_conselho && Storage::exists('public/fotos/' . $conselhoSeguranca->img_conselho)) {
                Storage::disk('public')->delete('fotos/' . $conselhoSeguranca->img_conselho);
            }
            if ($conselhoSeguranca->img_erro && Storage::exists('public/fotos/' . $conselhoSeguranca->img_erro)) {
                Storage::disk('public')->delete('fotos/' . $conselhoSeguranca->img_erro);
            }
            $conselhoSeguranca->delete();
        });
        return new ConselhoSegurancaResource($conselhoSeguranca);
    }
}
