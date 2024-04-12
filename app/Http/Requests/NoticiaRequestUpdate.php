<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequestUpdate extends FormRequest
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
            "rally_id" => "nullable|integer|exists:rallies,id",
            "titulo" => "sometimes|string",
            "conteudo" => "sometimes|string",
            "title_img" => "sometimes|file|image",
            "data" => "sometimes|date",
            'fotos_id' => 'nullable|array',
            'fotos_id.*' => 'integer|exists:fotos,id', // Validação para cada item do array
        ];
    }
}
