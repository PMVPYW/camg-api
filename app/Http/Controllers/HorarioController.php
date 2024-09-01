<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Http\Requests\HorarioUpdateRequest;
use App\Http\Resources\HorarioResource;
use App\Http\Resources\ProvaResource;
use App\Http\Resources\RallyResource;
use App\Models\Horario;
use App\Models\Prova;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HorarioResource::collection(Horario::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HorarioRequest $request)
    {
        $validated = $request->validated();
        $horario = new Horario();
        DB::transaction(function () use ($validated, &$horario) {
            $horario->fill($validated);
            $horario->save();
        });
        return new HorarioResource($horario);
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        return new HorarioResource($horario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HorarioUpdateRequest $request, Horario $horario)
    {
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $horario) {
            $horario->fill($validated);
            $horario->save();

            $provas = Prova::query()->where('horario_id', $horario->id);
            foreach ($provas as $prova) {
                $prova->horario_id = null;
                $prova->save();
            }
        });
        return new HorarioResource($horario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(horario $horario)
    {
        $provas = Prova::query()->where("horario_id", $horario->id)->get();

        foreach ($provas as $prova) {
            $prova->horario_id = null;
            $prova->save();
        }
        $horario->forceDelete();
        return new HorarioResource($horario);
    }

    public function getRally(Horario $horario) {
        return new RallyResource($horario->rally);
    }

    public function getProva(Horario $horario)
    {
        if ($horario->prova()->count() == 0) {
            return response()->json(['data' => null], 200);
        }
        return new ProvaResource($horario->prova);
    }
}
