<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaRequest extends FormRequest
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
            "titulo" => "required|string|min:0|unique:historia,titulo",
            "subtitulo" => "required|string|min:0",
            "conteudo" => "sometimes|nullable|string",
            "photo_url" => "sometimes|nullable|file|image"
        ];
    }
    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.min' => 'O campo título deve ter texto.',
            'titulo.unique' => 'O título fornecido já existe na tabela história.',
            'subtitulo.required' => 'O campo subtítulo é obrigatório.',
            'subtitulo.string' => 'O campo subtítulo deve ser um texto.',
            'subtitulo.min' => 'O campo subtítulo deve ter texto.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
        ];
    }
}
