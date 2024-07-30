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
            "title_img" => "required|file|image",
            "data" => "required|date"
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
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.unique' => 'Este título já está em uso.',
            'conteudo.required' => 'O campo conteúdo é obrigatório.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'title_img.required' => 'O campo capa noticia é obrigatório.',
            'title_img.file' => 'O campo capa noticia deve ser um arquivo.',
            'title_img.image' => 'O campo capa noticia deve ser uma imagem.',
            'data.required' => 'O campo data é obrigatório.',
            'data.date' => 'O campo data deve ser uma data válida.'
        ];
    }
}
