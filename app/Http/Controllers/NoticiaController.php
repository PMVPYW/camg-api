<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticiaRequest;
use App\Http\Requests\NoticiaRequestUpdate;
use App\Http\Resources\NoticiaResource;
use App\Models\Foto;
use App\Models\ImagemNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NoticiaResource::collection(Noticia::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoticiaRequest $request)
    {
        $validated= $request->validated();
        $noticia = null;
        DB::transaction(function() use ($validated, &$noticia, $request)
        {
            $image_noticia = null;
            $noticia = new Noticia();
            $noticia->fill($validated);
            $noticia->save();

            if(isset($request->fotos_id)){
                foreach ($request->fotos_id as $foto_id){

                    $image_noticia = new ImagemNoticia();
                    $image_noticia->noticia_id = $noticia->id;
                    $image_noticia->image_id = $foto_id;
                    $image_noticia->save();
                }
            }
        });
        return response(new NoticiaResource($noticia), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        return new NoticiaResource($noticia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoticiaRequestUpdate $request, Noticia $noticia)
    {
        $validated = $request->validated();
        DB::transaction(function() use ($validated, $noticia){
            $noticia->fill($validated);
            $noticia->save();
        });
        return new NoticiaResource($noticia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        DB::transaction(function () use($noticia){
            if(isset($noticia->imagens[0])) {
                foreach ($noticia->imagens as $imagem) {
                    $imagem_noticias=ImagemNoticia::find($imagem->id);
                    $imagem_noticias->forceDelete();
                    //$imagem_noticias->delete();
                    $noticia->forceDelete();
                    //$noticia->delete();
                }
            }else{
                $noticia->forceDelete();
            }
        });
        return new NoticiaResource($noticia);
    }

/*    //Metodos Auxiliares
    public function getImagebyNoticia_id(string $id)
    {
        $nome_fotos=[];
        $fotos_ids = ImagemNoticia::where('noticia_id', $id)->pluck('image_id')->toArray();
        if(count($fotos_ids)>0){
            foreach ($fotos_ids as $foto_id){
                $foto=Foto::find($foto_id);
                $nome_fotos[]=$foto->image_src;
            }
            return response()->json(['data' => $nome_fotos], 200);
        }else{
            return response()->json("Não tem fotos", 500);
        }
    }*/
}
