<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RallyResource extends JsonResource
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
            "data_fim" => $this->data_fim,
            "external_entity_id" => $this->external_entity_id,
            "photo_url" => $this->photo_url
        ];
    }
}
