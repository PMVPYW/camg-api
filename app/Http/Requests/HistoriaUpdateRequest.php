<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "capitulo_id" => "integer|sometimes|nullable|exists:capitulo,id",
            "titulo" => "sometimes|string|min:0|unique:historia,titulo",
            "subtitulo" => "sometimes|string|min:0",
            "conteudo" => "sometimes|string|nullable|",
            "photo_url" => "sometimes|nullable|file|image"
        ];
    }
}
