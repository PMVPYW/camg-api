<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntidadeRequest;
use App\Http\Requests\EntidadeRequestDelete;
use App\Http\Requests\EntidadeRequestUpdate;
use App\Http\Resources\EntidadeResource;
use App\Models\Entidade;
use App\Models\Patrocinio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        DB::transaction(function () use ($validated, &$entidade,$request){
            $entidade=new Entidade();
            if ($request->hasFile("photo_url")) {
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('entidades/' . $file_name_to_store, File::get($file));
                $entidade->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
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
        return new EntidadeResource($entidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntidadeRequestUpdate $request, Entidade $entidade)
    {
        $validated = $request->validated();
        DB::transaction(function() use ($validated, &$entidade, $request){
            if ($request->hasFile("photo_url")) {
                if ($entidade->photo_url && Storage::exists('public/entidades/' . $entidade->photo_url)) {
                    Storage::disk('public')->delete('entidades/' . $entidade->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('entidades/' . $file_name_to_store, File::get($file));
                $entidade->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $entidade->fill($validated);
            $entidade->save();
        });

        return new EntidadeResource($entidade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entidade $entidade)
    {
        DB::transaction(function () use($entidade){
            if(isset($entidade->patrocinios[0])) {
                $entidade->delete();
            }else{
                #hard delete
                if ($entidade->photo_url && Storage::exists('public/entidades/' . $entidade->photo_url)) {
                    Storage::disk('public')->delete('entidades/' . $entidade->photo_url);
                }
                $entidade->forceDelete();
            }
        });
        return new EntidadeResource($entidade);
    }

    public function destroyAllEntities(EntidadeRequestDelete $entidades)
    {
        $deleted_entities=[];
        DB::transaction(function () use($entidades, &$deleted_entities){
            $entidadesIds = $entidades->input('entidades_id', []);
            if (!empty($entidadesIds)) {
                foreach ($entidadesIds as $entidadesId){
                    $entidade = Entidade::find($entidadesId);
                        if(!(isset($entidade->patrocinios[0]))) {
                            if ($entidade->photo_url && Storage::exists('public/entidades/' . $entidade->photo_url)) {
                                Storage::disk('public')->delete('entidades/' . $entidade->photo_url);
                            }
                            $deleted_entities[]=$entidade;
                            $entidade->forceDelete();
                        }
                    }
            }
        });
        return EntidadeResource::collection($deleted_entities);
    }
}
