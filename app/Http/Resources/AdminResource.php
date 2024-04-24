<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            "email" => $this->email,
            "authorized" => $this->authorized,
            "photo_url" => $this->photo_url,
            "blocked" => $this->blocked,
        ];
    }
}
