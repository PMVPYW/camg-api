<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "photo_url" => $this->photo_url,
            "url" => $this->url,
            "rallys" =>  $this->patrocinios
        ];
    }
}
