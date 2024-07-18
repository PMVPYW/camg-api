<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoriaResource;
use App\Http\Requests\{HistoriaCompletaRequest,
    HistoriaCompletaUpdateRequest,
    HistoriaFiltersRequest,
    HistoriaRequest,
    HistoriaUpdateRequest};
use App\Models\Capitulo;
use App\Models\Etapa;
use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HistoriaController extends Controller
{
    public function index(HistoriaFiltersRequest $request)
    {
        $historias=Historia::query();
        if ($request->order == 'subtitulo_desc') {
            $historias = $historias->orderBy('subtitulo', 'desc');
        } else if ($request->order == 'subtitulo_asc') {
            $historias = $historias->orderBy('subtitulo', 'asc');
        }

        if ($request->order == 'titulo_desc') {
            $historias = $historias->orderBy('titulo', 'desc');
        } else if ($request->order == 'titulo_asc') {
            $historias = $historias->orderBy('titulo', 'asc');
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $historias = $historias->where('titulo', 'LIKE', "%{$request->search}%")
                ->orWhere('conteudo', 'LIKE', "%{$request->search}%")
                ->orWhere('subtitulo', 'LIKE', "%{$request->search}%");
        }
        return HistoriaResource::collection($historias->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoriaRequest $request)
    {
        $validated= $request->validated();
        $historia = null;
        DB::transaction(function() use ($validated, &$historia, $request)
        {
            $historia = new Historia();
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();
        });
        return response(new HistoriaResource($historia), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Historia $historia)
    {
        return new HistoriaResource($historia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HistoriaUpdateRequest $request, Historia $historia)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$historia, $request)
        {
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();
        });
        return new HistoriaResource($historia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historia $historia)
    {
        DB::transaction(function () use ($historia) {
            foreach ($historia->capitulos as $capitulo) {
                foreach ($capitulo->etapas as $etapa){
                    $etapa->forceDelete();
                }
                $capitulo->forceDelete();
            }
            $historia->forceDelete();
        });
        return new HistoriaResource($historia);
    }

    public function store_historia_completa(HistoriaCompletaRequest $request)
    {
        $validated= $request->validated();
        $historia = null;
        DB::transaction(function() use ($validated, &$historia, $request)
        {
            $historia = new Historia();
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();

            // Criar capítulos
            if (isset($validated['capitulos'])) {
                foreach ($validated['capitulos'] as $capituloData) {
                    $capitulo = new Capitulo();
                    $capitulo->fill($capituloData);
                    $capitulo->historia_id = $historia->id;
                    $capitulo->save();

                    // Criar etapas para cada capítulo
                    if (isset($validated['etapas'])) {
                        foreach ($validated['etapas'] as $etapaData) {
                            if ($etapaData['capitulo_id'] == $capituloData['capitulo_id']) {
                                $etapa = new Etapa();
                                $etapa->fill($etapaData);
                                $etapa->capitulo_id = $capitulo->id;
                                $etapa->save();
                            }
                        }
                    }
                }
            }
        });
        return response(new HistoriaResource($historia), 201);
    }

    public function update_historia_completa(HistoriaCompletaUpdateRequest $request, Historia $historia)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, &$historia, $request) {
            if ($request->hasFile("photo_url")) {
                if ($historia->photo_url && Storage::exists('public/fotos/' . $historia->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $historia->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $historia->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $historia->fill($validated);
            $historia->save();

            $capituloIdsFromRequest = array_column($validated['capitulos'], 'id');
            $etapaIdsFromRequest = array_column($validated['etapas'], 'id');

            $capitulos_para_eliminar = Capitulo::where('historia_id', $historia->id)
                ->whereNotIn('id', $capituloIdsFromRequest)->get();

            foreach ($capitulos_para_eliminar as $capitulo) {
                foreach ($capitulo->etapas as $etapa){
                    $etapa->forceDelete();
                }
                $capitulo->forceDelete();
            }

            // Editar capítulos
            if (isset($validated['capitulos'])) {
                foreach ($validated['capitulos'] as $capituloData) {
                    $capitulo = Capitulo::find($capituloData['id']) ?? new Capitulo();
                    $capitulo->fill($capituloData);
                    $capitulo->historia_id = $historia->id;
                    $capitulo->save();

                    $etapas_para_eliminar = Etapa::where('capitulo_id', $capitulo->id)
                        ->whereNotIn('id', $etapaIdsFromRequest)->get();

                    foreach ($etapas_para_eliminar as $etapa){
                        $etapa->forceDelete();
                    }

                    //Editar etapas
                    if (isset($validated['etapas'])) {
                        foreach ($validated['etapas'] as $etapaData) {
                            if ($etapaData['capitulo_id'] == $capituloData['capitulo_id']) {
                                $etapa = Etapa::find($etapaData['id']) ?? new Etapa();
                                $etapa->fill($etapaData);
                                $etapa->capitulo_id = $capitulo->id;
                                $etapa->save();
                            }
                        }
                    }
                }
            }
        });
        return response(new HistoriaResource($historia));
    }

}
