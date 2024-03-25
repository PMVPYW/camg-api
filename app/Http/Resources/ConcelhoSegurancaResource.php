<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConcelhoSegurancaResource extends JsonResource
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
            "descricao" => $this->descricao,
            "img_conselho" => $this->img_conselho,
            "erro" => $this->erro,
            "img_erro" => $this->img_erro
            ];
    }
}
