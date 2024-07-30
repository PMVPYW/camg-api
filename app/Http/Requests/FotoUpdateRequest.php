<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoUpdateRequest extends FormRequest
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
            "album_id" => "sometimes|integer|exists:albuns,id",
            "image_src" => "sometimes|file|image",
            "description" => "sometimes|string"
        ];
    }
    public function messages(): array
    {
        return [
            'album_id.integer' => 'O campo album deve ser um número inteiro.',
            'album_id.exists' => 'O album fornecido não existe na tabela albuns.',
            'image_src.file' => 'O campo imagem deve ser um arquivo.',
            'image_src.image' => 'O campo deve ser uma imagem.',
            'description.string' => 'O campo descrição deve ser um texto.',
        ];
    }
}
