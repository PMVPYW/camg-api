<?php

namespace App\Http\Resources;

use App\Models\TipoContacto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactoResource extends JsonResource
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
            "tipo_valor" => $this->tipo_valor,
            "valor" => $this->valor,
            "tipocontacto_id" => $this->tipocontacto_id
        ];
    }
}
