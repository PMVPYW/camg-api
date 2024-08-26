<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticiaFiltersRequest;
use App\Http\Requests\NoticiaRequest;
use App\Http\Requests\NoticiaRequestUpdate;
use App\Http\Resources\NoticiaResource;
use App\Models\Foto;
use App\Models\ImagemNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NoticiaFiltersRequest $request)
    {
        $noticias=Noticia::query();
        if ($request->order == 'date_desc') {
            $noticias = $noticias->orderBy('data', 'desc');
        } else if ($request->order == 'date_asc') {
            $noticias = $noticias->orderBy('data', 'asc');
        }

        if ($request->order == 'titulo_desc') {
            $noticias = $noticias->orderBy('titulo', 'desc');
        } else if ($request->order == 'titulo_asc') {
            $noticias = $noticias->orderBy('titulo', 'asc');
        }

        if ($request->data_inicio) {
            $noticias = $noticias->where([["data", ">=", $request->data_inicio]]);//acabam dps do inicio da pesquisa
        }
        if ($request->data_fim) {
            $noticias = $noticias->where([["data", "<=", $request->data_fim]]);// começam antes do fim da pesquisa
        }

        if($request->rally_id){
            $noticias->where([["rally_id", $request->rally_id]]);
        }

        if ($request->search && strlen($request->search) > 0)
        {
            $noticias = $noticias->where('titulo', 'LIKE', "%{$request->search}%")
                ->orWhere('conteudo', 'LIKE', "%{$request->search}%");
        }

        return NoticiaResource::collection($noticias->get());
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
            $noticia = new Noticia();
            if ($request->hasFile("title_img")) {
                if ($noticia->title_img && Storage::exists('public/fotos/' . $noticia->title_img)) {
                    Storage::disk('public')->delete('fotos/' . $noticia->title_img);
                }
                $file = $request->file("title_img");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = str_replace('=', '', base64_encode(microtime()));
                while(Storage::disk('public')->exists('fotos/'.$file_name_to_store . '.' . $file_type))
                {
                    $file_name_to_store = $file_name_to_store . random_int();
                }
                $file_name_to_store = $file_name_to_store . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $noticia->title_img = $file_name_to_store;
            }
            unset($validated["title_img"]);
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
        DB::transaction(function() use ($validated, &$noticia, $request){
            if ($request->hasFile("title_img")) {
                if ($noticia->title_img && Storage::exists('public/fotos/' . $noticia->title_img)) {
                    Storage::disk('public')->delete('fotos/' . $noticia->title_img);
                }
                $file = $request->file("title_img");
                $file_type = $file->getClientOriginalExtension();
                $file_name_to_store = str_replace('=', '', base64_encode(microtime()));
                while(Storage::disk('public')->exists('fotos/'.$file_name_to_store . '.' . $file_type))
                {
                    $file_name_to_store = $file_name_to_store . random_int();
                }
                $file_name_to_store = $file_name_to_store . '.' . $file_type;
                Storage::disk('public')->put('fotos/' . $file_name_to_store, File::get($file));
                $noticia->title_img = $file_name_to_store;
            }
            unset($validated["title_img"]);
            if(isset($request->fotos_id)){
                if(isset($noticia->imagens[0])) {
                    foreach ($noticia->imagens as $imagem) {
                        $imagem_noticias=ImagemNoticia::find($imagem->id);
                        $imagem_noticias->forceDelete();
                    }
                }
                foreach ($request->fotos_id as $foto_id){
                    $image_noticia = new ImagemNoticia();
                    $image_noticia->noticia_id = $noticia->id;
                    $image_noticia->image_id = $foto_id;
                    $image_noticia->save();
                }
            }
            $noticia->fill($validated);
            $noticia->save();
            $noticia=Noticia::find($noticia->id);
        });
        return response(new NoticiaResource($noticia), 201);
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
                    $foto = Foto::withTrashed()->find($imagem_noticias->image_id);
                    $imagem_noticias->forceDelete();
                    if ($foto->deleted_at != null)
                    {
                        Storage::disk('public')->delete('fotos/' . $foto->image_src);
                        $foto->forceDelete();
                    }
                }
            }
            Storage::disk('public')->delete('fotos/' . $noticia->title_img);
            $noticia->forceDelete();
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
