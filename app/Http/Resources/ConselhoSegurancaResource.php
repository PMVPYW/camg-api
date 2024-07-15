<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConselhoSegurancaResource extends JsonResource
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
            "descricao" => $this->descricao,
            "img_conselho" => $this->img_conselho,
            "erro" => $this->erro,
            "img_erro" => $this->img_erro
            ];
    }
}
