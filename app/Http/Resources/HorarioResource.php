<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HorarioResource extends JsonResource
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
            "rally_id" => $this->rally_id,
            "titulo" => $this->titulo,
            "descricao" => $this->descricao,
            "inicio" => $this->inicio,
            "inicio_dia" => $this->inicio->format('d-m-Y'),
            "inicio_hora" => $this->inicio->format('H:i'),
            "fim" => $this->fim,
            "fim_dia" => $this->fim->format('d-m-Y'),
            "fim_hora" => $this->fim->format('H:i')
        ];
    }
}
