<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Http\Requests\HorarioUpdateRequest;
use App\Http\Resources\HorarioResource;
use App\Models\Horario;
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
            $horario = new Horario();
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
        });
        return new HorarioResource($horario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
