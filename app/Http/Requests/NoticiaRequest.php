<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
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
            'fotos_id' => 'nullable|array',
            'fotos_id.*' => 'integer|exists:fotos,id', // Validação para cada item do array
            "rally_id" => "nullable|integer|exists:rallies,id",
            "titulo" => "required|string|unique:noticias,titulo",
            "conteudo" => "required|string",
            "title_img" => "file|image",
            "data" => "required|date"
        ];
    }
}
