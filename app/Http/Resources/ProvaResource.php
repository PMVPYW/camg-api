<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvaResource extends JsonResource
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
            "data_inicio" => $this->data_inicio,
            "rally_id" => $this->rally_id,
            "external_id" => $this->external_id,
            "local" => $this->local,
            "distancia_percurso" => $this->distancia_percurso,
        ];
    }
}
