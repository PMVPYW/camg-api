<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPatrociniosFiltersRequest;
use App\Http\Requests\PatrocinioRequestDelete;
use App\Http\Requests\RallyFiltersRequest;
use App\Http\Requests\RallyRequest;
use App\Http\Requests\RallyRequestUpdate;
use App\Http\Resources\EntidadeResource;
use App\Http\Resources\HorarioResource;
use App\Http\Resources\PatrocinioResource;
use App\Http\Resources\RallyResource;
use App\Models\Entidade;
use App\Models\Rally;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;

class RallyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RallyFiltersRequest $request)
    {
        //request validation
        $validated_data = $request->validated();
        $rallies = Rally::query();
        if (!$request->order || $request->order == 'proximity') {
            $rallies = $rallies->orderByRaw("ABS(DATEDIFF(data_inicio, ?)) ASC", [today()]);
        } else if ($request->order == 'date_desc') {
            $rallies = $rallies->orderBy('data_inicio', 'desc');
        } else if ($request->order == 'date_asc') {
            $rallies = $rallies->orderBy('data_inicio', 'asc');
        }

        if ($request->data_inicio) {
            $rallies = $rallies->where([["data_fim", ">=", $request->data_inicio]]);//acabam dps do inicio da pesquisa
        }
        if ($request->data_fim) {
            $rallies = $rallies->where([["data_inicio", "<=", $request->data_fim]]);// começam antes do fim da pesquisa
        }

        //if (!$request->status || $request->status == "all") --> n é preciso pq já vem
        if ($request->status == "not_started") {
            $rallies = $rallies->where("data_inicio", ">", today());
        } else if ($request->status == "on_going") {
            $rallies = $rallies->where([["data_inicio", "<=", today()],
                ["data_fim", ">=", today()]
            ]);
        } else if ($request->status == "terminated") {
            $rallies->where("data_fim", "<", today());
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $rallies = $rallies->where('nome', 'LIKE', "%{$request->search}%");
        }

        return RallyResource::collection($rallies->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RallyRequest $request)
    {
        $validated = $request->validated();
        $rally = null;
        DB::transaction(function () use ($validated, &$rally, $request) {
            $rally = new Rally();
            if ($request->hasFile("photo_url")) {
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $rally->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $rally->fill($validated);
            $rally->save();
        });
        return response(new RallyResource($rally), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rally = Rally::findOrFail($id);
        return new RallyResource($rally);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RallyRequestUpdate $request, Rally $rally)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $rally, $request) {
            if ($request->hasFile("photo_url")) {
                if ($rally->photo_url && Storage::exists('public/fotos/' . $rally->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $rally->photo_url);
                }
                $file = $request->file("photo_url");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $rally->photo_url = $file_name_to_store;
            }
            unset($validated["photo_url"]);
            $rally->fill($validated);
            $rally->save();
        });
        return new RallyResource($rally);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rally $rally)
    {
        DB::transaction(function () use ($rally) {
            if ($rally->noticias()->count() + $rally->Albuns()->count() == 0) {
                #hard delete
                if ($rally->photo_url && Storage::exists('public/fotos/' . $rally->photo_url)) {
                    Storage::disk('public')->delete('fotos/' . $rally->photo_url);
                }
                $rally->forceDelete();
            } else {
                #soft delete
                $rally->delete();
            }

        });
        return new RallyResource($rally);
    }


    //Metodos auxiliares
    //Patrocinios
    public function getPatrocinios(GetPatrociniosFiltersRequest $request, Rally $rally)
    {
        $filters = $request->filters;
        $patrocinios = $rally->patrocinios;
        $patrocinios = $patrocinios->where("entidade_oficial",false);

        switch ($filters) {
            case 'nome_asc':
                $patrocinios = $patrocinios->sortBy(function ($patrocinio) {
                    return $patrocinio->entidade->nome;
                });
                break;
            case 'nome_desc':
                $patrocinios = $patrocinios->sortByDesc(function ($patrocinio) {
                    return $patrocinio->entidade->nome;
                });
                break;
        }
        return PatrocinioResource::collection($patrocinios);
    }


    public function getPatrociniosSemAssociacao(Rally $rally)
    {
        $entidadesSemAssociacao = Entidade::whereNotIn('id',  $rally->patrocinios->pluck('entidade_id'))->where("entidade_oficial",false)->get();
        return EntidadeResource::collection($entidadesSemAssociacao);
    }

    //Relevância dos Patrocinios
    public function getPatrociniosRelevancia(Rally $rally)
    {
        $patrocinios = $rally->patrocinios;
        $patrocinios = $patrocinios->where("entidade_oficial",false);
        $relevancia=[];
        foreach ($patrocinios as $patrocinio){
            dump($patrocinio->relevancia);
            $relevancia[]=$patrocinio->relevancia;
        }
        dd($relevancia);
        return PatrocinioResource::collection($patrocinios);
    }


    //PatrociniosOficiais
    public function getPatrociniosOficiais(GetPatrociniosFiltersRequest $request, Rally $rally)
    {
        $filters = $request->filters;
        $patrocinios = $rally->patrocinios;
        $patrocinios = $patrocinios->where("entidade_oficial",true);

        switch ($filters) {
            case 'nome_asc':
                $patrocinios = $patrocinios->sortBy(function ($patrocinio) {
                    return $patrocinio->entidade->nome;
                });
                break;
            case 'nome_desc':
                $patrocinios = $patrocinios->sortByDesc(function ($patrocinio) {
                    return $patrocinio->entidade->nome;
                });
                break;
        }
        return PatrocinioResource::collection($patrocinios);
    }

    function getHorarios(Rally $rally)
    {
        return HorarioResource::collection($rally->horarios);
    }


    public function getPatrociniosOficiaisSemAssociacao(Rally $rally)
    {
        $entidadesSemAssociacao = Entidade::whereNotIn('id',  $rally->patrocinios->pluck('entidade_id'))->where("entidade_oficial",true)->get();
        return EntidadeResource::collection($entidadesSemAssociacao);
    }
}
