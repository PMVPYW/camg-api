<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclaracaoFiltersRequest;
use App\Http\Requests\GetPatrociniosFiltersRequest;
use App\Http\Requests\PatrocinioRequestDelete;
use App\Http\Requests\ProvaFiltersRequest;
use App\Http\Requests\RallyFiltersRequest;
use App\Http\Requests\RallyRequest;
use App\Http\Requests\RallyRequestUpdate;
use App\Http\Requests\ZonaEspetaculoFiltersRequest;
use App\Http\Resources\DeclaracaoResource;
use App\Http\Resources\EntidadeResource;
use App\Http\Resources\HorarioResource;
use App\Http\Resources\PatrocinioResource;
use App\Http\Resources\ProvaResource;
use App\Http\Resources\RallyResource;
use App\Http\Resources\ZonaEspetaculoResource;
use App\Models\Declaracao;
use App\Models\Entidade;
use App\Models\Prova;
use App\Models\Rally;
use App\Models\ZonaEspetaculo;
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

        $controller = new ProvaController();

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
            foreach ($rally->patrocinios as $patrocinio){
                $patrocinio->forceDelete();
            }
            foreach ($rally->provas as $prova){
                $prova->forceDelete();
            }
            foreach ($rally->horarios as $horario){
                $horario->forceDelete();
            }
            foreach ($rally->noticias as $noticia){
                $noticia->rally_id=null;
                $noticia->save();
            }
            foreach ($rally->Albuns as $album){
                $album->rally_id=null;
                $album->save();
            }
            foreach ($rally->declaracoes as $declaracao)
            {
                $declaracao->forceDelete();
            }
            $rally->forceDelete();
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
            case 'rel_asc':
                $patrocinios = $patrocinios->sortByAsc(function ($patrocinio) {
                    return $patrocinio->relevancia;
                });
            break;
            default:
                $patrocinios = $patrocinios->sortByDesc(function ($patrocinio) {
                    return $patrocinio->relevancia;
                });
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
        $patrocinios = $patrocinios->where("entidade_oficial", false);
        $relevancia = [];
        $patrocinios_relevancia = [];

        foreach ($patrocinios as $patrocinio) {
            $relevancia[] = $patrocinio->relevancia-1;
            $patrocinios_relevancia[] = $patrocinio;
        }
        $count_relevancia=array_sum($relevancia)+count($patrocinios);
        for ($j=0; $j<$count_relevancia; $j++){
            $i=0;
            for ($i; $i < count($patrocinios); $i++) {
                if ($relevancia[$i] > 0) {
                    $relevancia[$i]--;
                    array_push($patrocinios_relevancia, $patrocinios_relevancia[$i]);
                }
            }
        }
        return PatrocinioResource::collection($patrocinios_relevancia);
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
        return HorarioResource::collection($rally->horarios()->orderBy("inicio", 'asc')->get());
    }


    public function getPatrociniosOficiaisSemAssociacao(Rally $rally)
    {
        $entidadesSemAssociacao = Entidade::whereNotIn('id',  $rally->patrocinios->pluck('entidade_id'))->where("entidade_oficial",true)->get();
        return EntidadeResource::collection($entidadesSemAssociacao);
    }

    //ZonaEspetaculo
    public function getZonasEspetaculo(ZonaEspetaculoFiltersRequest $request, Rally $rally)
    {
        $request->validated();

        $zonasEspetaculo=ZonaEspetaculo::query();
        $provaIds = $rally->provas->pluck('id');
        $zonasEspetaculo->whereIn('prova_id', $provaIds);

        if ($request->prova_id) {
            $zonasEspetaculo->where('prova_id', $request->prova_id);
        }
        if ($request->nivel_afluencia) {
           $zonasEspetaculo->where("nivel_afluencia", "LIKE", $request->nivel_afluencia);
        }
        if ($request->facilidade_acesso) {
            $zonasEspetaculo->where("facilidade_acesso", "LIKE", $request->facilidade_acesso);
        }
        if ($request->nivel_ocupacao) {
            $zonasEspetaculo->where("nivel_ocupacao", "LIKE", $request->nivel_ocupacao);
        }
        if ($request->search && strlen($request->search) > 0)
        {
            $zonasEspetaculo->where('nome', 'LIKE', "%{$request->search}%");
        }
        return ZonaEspetaculoResource::collection($zonasEspetaculo->get());
    }

    //Declarações
    public function getDeclaracoes(DeclaracaoFiltersRequest $request,Rally $rally)
    {
        $declaracoes=$rally->declaracoes();
        if ($request->order == 'nome_desc') {
            $declaracoes = $declaracoes->orderBy('nome', 'desc');
        } else if ($request->order == 'nome_asc') {
            $declaracoes = $declaracoes->orderBy('nome', 'asc');
        } else if ($request->order == 'cargo_desc') {
            $declaracoes = $declaracoes->orderBy('cargo', 'desc');
        } else if ($request->order == 'cargo_asc') {
            $declaracoes = $declaracoes->orderBy('cargo', 'asc');
        }

        if ($request->select == 'piloto') {
            $declaracoes = $declaracoes->where('cargo', 'LIKE', 'piloto');
        } else if ($request->select == 'presidente'){
            $declaracoes = $declaracoes->where('cargo', 'LIKE', 'presidente');
        } else if ($request->select == 'copiloto'){
            $declaracoes = $declaracoes->where('cargo', 'LIKE', 'copiloto');
        }

        if ($request->search && strlen($request->search) > 0) {
            $declaracoes = $declaracoes->where(function($query) use ($request) {
                $query->where('nome', 'LIKE', "%{$request->search}%")
                    ->orWhere('conteudo', 'LIKE', "%{$request->search}%")
                    ->orWhere('entidade_equipa', 'LIKE', "%{$request->search}%");
            });
        }
        if ($request->search_outro && strlen($request->search_outro) > 0) {
            $declaracoes = $declaracoes->where(function($query) use ($request) {
                $query->where('cargo', 'LIKE', "%{$request->search_outro}%");
            });
        }
        return DeclaracaoResource::collection($declaracoes->get());
    }

    //Provas
    public function getProvas(ProvaFiltersRequest $request,Rally $rally)
    {
        $provas = $rally->provas();
        if ($request->order == 'nome_desc') {
            $provas = $provas->orderBy('nome', 'desc');
        } else if ($request->order == 'nome_asc') {
            $provas = $provas->orderBy('nome', 'asc');
        } else if ($request->order == 'local_desc') {
            $provas = $provas->orderBy('local', 'desc');
        } else if ($request->order == 'local_asc') {
            $provas = $provas->orderBy('local', 'asc');
        }else if ($request->order == 'distancia_percurso_asc') {
            $provas = $provas->orderBy('distancia_percurso', 'asc');
        } else if ($request->order == 'distancia_percurso_desc') {
            $provas = $provas->orderBy('distancia_percurso', 'desc');
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $provas = $provas->where('nome', 'LIKE', "%{$request->search}%")
                ->orWhere('local', 'LIKE', "%{$request->search}%");
        }
        return ProvaResource::collection($provas->get());
    }
}
