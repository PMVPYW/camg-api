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

    public function messages(): array
    {
        return [
            'fotos_id.array' => 'O campo fotos deve ser um vetor.',
            'fotos_id.*.integer' => 'Cada item deve ser um número inteiro.',
            'fotos_id.*.exists' => 'Cada item deve existir na tabela fotos.',
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe na tabela rallies.',
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.unique' => 'Este título já está em uso.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'title_img.file' => 'O campo capa noticia deve ser um arquivo.',
            'title_img.image' => 'O campo capa noticia deve ser uma imagem.',
            'data.date' => 'O campo data deve ser uma data válida.'
        ];
    }
}
