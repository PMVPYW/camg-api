<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivestreamFiltersRequest;
use App\Http\Requests\LivestreamRequest;
use App\Http\Requests\LivestreamUpdateRequest;
use App\Http\Resources\LivestreamResource;
use App\Models\Livestream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivestreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LivestreamFiltersRequest $request)
    {
        $livestream = Livestream::query();
        $livestream = $livestream->orderBy('enable_timestamp', 'desc');
        if ($request->order == 'enable') {
            $livestream = $livestream->where([["visivel", 1]]);// começam antes do fim da pesquisa
        } else if ($request->order == 'disable'){
            $livestream = $livestream->where([["visivel", 0]]);// começam antes do fim da pesquisa
        }

        if($request->rally_id){
            $livestream->where([["rally_id", $request->rally_id]]);
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $livestream = $livestream->where('nome', 'LIKE', "%{$request->search}%");
        }
        return LivestreamResource::collection($livestream->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LivestreamRequest $request)
    {
        $validated= $request->validated();
        $livestream = null;
        DB::transaction(function() use ($validated, &$livestream)
        {
            $livestream = new Livestream();
            $livestream->fill($validated);
            $livestream->enable_timestamp = new \DateTime();
            $livestream->save();
        });
        dump($livestream);
        return response(new LivestreamResource($livestream), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestream $livestream)
    {
        return new LivestreamResource($livestream);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LivestreamUpdateRequest $request, Livestream $livestream)
    {
        $validated= $request->validated();
        DB::transaction(function() use ($validated, $livestream)
        {
            $livestream->fill($validated);
            if($livestream->visivel){
                foreach (Livestream::all() as $live){
                    $live->visivel = $live->id === $livestream->id ? 1 : 0;
                    $live->save();
                }
                $livestream->enable_timestamp =new \DateTime();
            }
            $livestream->save();
        });
        return response(new LivestreamResource($livestream), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestream $livestream)
    {
        $livestream->forceDelete();
        return new LivestreamResource($livestream);
    }
}
