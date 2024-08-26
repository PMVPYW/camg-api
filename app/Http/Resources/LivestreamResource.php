<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivestreamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nome' => $this->nome,
            'link' => $this->link,
            'rally_id' => $this->rally ?? null,
            'visivel' => $this->visivel,
            'enable_timestamp' => $this->enable_timestamp
        ];
    }
}
