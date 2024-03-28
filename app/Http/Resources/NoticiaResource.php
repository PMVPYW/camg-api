<?php

namespace App\Http\Resources;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imagensArray = [];
        foreach ($this->imagens as $image) {
            $imagensArray[] = $image->foto;
        }
        return [
            "id" => $this->id,
            "rally_id" => $this->rally_id,
            "titulo" => $this->titulo,
            "conteudo" => $this->conteudo,
            "title_img" => $this->title_img,
            "data" => $this->data,
            "img_noticia" => $imagensArray,
        ];
    }
}
