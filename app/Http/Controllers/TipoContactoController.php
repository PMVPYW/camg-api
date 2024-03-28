<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoContactoRequest;
use App\Http\Requests\TipoContactoRequestUpdate;
use App\Http\Resources\TipoContactoResource;
use App\Models\Contacto;
use App\Models\TipoContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TipoContactoResource::collection(TipoContacto::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoContactoRequest $request)
    {
        $validated= $request->validated();
        $tipo_contacto = null;
        DB::transaction(function() use ($validated, &$tipo_contacto)
        {
            $tipo_contacto = new TipoContacto();
            $tipo_contacto->fill($validated);
            $tipo_contacto->save();
        });
        return response(new TipoContactoResource($tipo_contacto), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoContacto $tipocontacto)
    {
        return new TipoContactoResource($tipocontacto);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoContactoRequestUpdate $request, TipoContacto $tipocontacto)
    {
        $validated=$request->validated();
        DB::transaction(function() use ($validated, $tipocontacto)
        {
            $tipocontacto->fill($validated);
            $tipocontacto->save();
        });
        return new TipoContactoResource($tipocontacto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoContacto $tipocontacto)
    {
        $quantidadeContactos = DB::table('contactos')
            ->where('tipocontacto_id', $tipocontacto->id)
            ->count();

        DB::transaction(function () use($tipocontacto, $quantidadeContactos){
            if($quantidadeContactos>0) {
                $tipocontacto->delete();
            }else{
                #hard delete
                $tipocontacto->forceDelete();
            }
        });
        return new TipoContactoResource($tipocontacto);
    }
}
