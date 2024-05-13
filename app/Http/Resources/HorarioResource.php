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
        $inicio = strtotime($this->inicio);
        $fim = strtotime($this->fim);
        return [
            "id" => $this->id,
            "rally_id" => $this->rally_id,
            "titulo" => $this->titulo,
            "descricao" => $this->descricao,
            "inicio" => $this->inicio,
            "inicio_dia" => date('d-m-Y', $inicio),
            "inicio_hora" => date('H:i', $inicio),
            "fim" => $this->fim,
            "fim_dia" => date('d-m-Y', $fim),
            "fim_hora" => date('H:i', $fim)
        ];
    }
}
