<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoRequest extends FormRequest
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
            "album_id" => "integer|required|exists:albuns,id",
            "image_src" => "required|array|min:1",
            "image_src.*" => "required|file|image",
            "description" => "sometimes|string"
        ];
    }
    public function messages(): array
    {
        return [
            'album_id.integer' => 'O campo album deve ser um número inteiro.',
            'album_id.required' => 'O campo album é obrigatório.',
            'album_id.exists' => 'O album fornecido não existe na tabela albuns.',
            'image_src.required' => 'O campo imagem é obrigatório.',
            'image_src.array' => 'O campo imagem deve ser um vetor de imagens.',
            'image_src.min' => 'O campo imagem deve conter pelo menos 1 imagem.',
            'image_src.*.required' => 'Cada item no campo imagem é obrigatório.',
            'image_src.*.file' => 'Cada item deve ser um arquivo.',
            'image_src.*.image' => 'Cada item deve ser uma imagem.',
            'description.string' => 'O campo descrição deve ser um texto.',
        ];
    }
}
