<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactoFiltersRequest;
use App\Http\Requests\ContactoRequest;
use App\Http\Requests\ContactoRequestUpdate;
use App\Http\Resources\ContactoResource;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactoFiltersRequest $request)
    {
        $contacts=Contacto::query();
        if($request->tipo_contacto_id){
            $contacts->where([["tipocontacto_id", $request->tipo_contacto_id]]);
        }
        return ContactoResource::collection($contacts->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactoRequest $request)
    {
        $validated= $request->validated();
        $contacto = null;
        DB::transaction(function() use ($validated, &$contacto)
        {
            $contacto = new Contacto();
            $contacto->fill($validated);
            $contacto->save();
        });
        return response(new ContactoResource($contacto), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        return new ContactoResource($contacto);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactoRequestUpdate $request, Contacto $contacto)
    {
        $validated=$request->validated();
        DB::transaction(function() use ($validated, $contacto){
            $contacto->fill($validated);
            $contacto->save();
        });
        return new ContactoResource($contacto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->forceDelete();
        return new ContactoResource($contacto);
    }
}
