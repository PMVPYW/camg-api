<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonaEspetaculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id" => $this->id,
            "nome" => $this->nome,
            "nivel_afluencia" => $this->nivel_afluencia,
            "facilidade_acesso" => $this->facilidade_acesso,
            "distancia_estacionamento" => $this->distancia_estacionamento,
            "nivel_ocupacao" => $this->nivel_ocupacao,
            "coordenadas" => $this->coordenadas,
            "prova"=> $this->prova
        ];
    }
}
