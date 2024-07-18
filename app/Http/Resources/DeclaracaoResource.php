<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeclaracaoResource extends JsonResource
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
            "rally_id" => $this->rally,
            "conteudo" => $this->conteudo,
            "nome" => $this->nome,
            "cargo" => $this->cargo,
            "photo_url" => $this->photo_url,
            "entidade_equipa" => $this->entidade_equipa,
            "pontos" => $this->pontos
        ];
    }
}

