<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeclaracaoUpdateRequest extends FormRequest
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
            "nome" => "sometimes|string",
            "photo_url" => 'sometimes|file|image',
            "conteudo" => "sometimes|string",
            "rally_id" => "sometimes|integer|exists:rallies,id",
            "cargo" => "sometimes|string",
            "entidade_equipa"=>"sometimes|nullable|string",
            "pontos"=>"sometimes|nullable|integer"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.string' => 'O campo nome deve ser um texto.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe na tabela rallies.',
            'cargo.string' => 'O campo cargo deve ser um texto.',
            'entidade_equipa.string' => 'O campo entidade/equipa deve ser um texto.',
            'pontos.integer' => 'O campo pontos deve ser um número inteiro.',
        ];
    }
}
