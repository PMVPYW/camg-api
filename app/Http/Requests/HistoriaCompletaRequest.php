<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaCompletaRequest extends FormRequest
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
            "etapas" => "sometimes|array",
            'etapas.*' => 'sometimes|array',
            'etapas.*.capitulo_id' => "sometimes|integer",
            'etapas.*.nome' => EtapaRequest::rulesArray()['nome'],
            'etapas.*.ano_inicio' => 'required|integer|digits:4',
            'etapas.*.ano_fim' => 'sometimes|nullable|integer|digits:4|gte:etapas.*.ano_inicio',
            "capitulos" => "sometimes|array",
            'capitulos.*' => 'sometimes|array',
            'capitulos.*.capitulo_id' => "sometimes|integer",
            'capitulos.*.titulo' => CapituloRequest::rulesArray()['titulo'],
            "titulo" => "required|string|min:0|unique:historia,titulo",
            "subtitulo" => "required|string|min:0",
            "conteudo" => "sometimes|nullable|string",
            "photo_url" => "sometimes|nullable|file|image"
        ];
    }

    public function messages(): array
    {
        return [
            'etapas.array' => 'O campo etapas deve ser um array.',
            'etapas.*.array' => 'Cada item em etapas deve ser um vetor.',
            'etapas.*.capitulo_id.integer' => 'O campo capitulo deve ser um número inteiro.',
            'etapas.*.nome' => EtapaRequest::messages()['nome'],
            'etapas.*.ano_inicio.required' => 'O campo ano inicio é obrigatório.',
            'etapas.*.ano_inicio.integer' => 'O campo ano inicio deve ser um número inteiro.',
            'etapas.*.ano_inicio.digits' => 'O campo ano inicio deve ter exatamente 4 dígitos.',
            'etapas.*.ano_fim.integer' => 'O campo ano fim deve ser um número inteiro.',
            'etapas.*.ano_fim.digits' => 'O campo ano fim deve ter exatamente 4 dígitos.',
            'etapas.*.ano_fim.gte' => 'O campo ano fim deve ser maior ou igual ao ano inicio.',

            'capitulos.array' => 'O campo capitulos deve ser um vetor.',
            'capitulos.*.array' => 'Cada item em capitulos deve ser um vetor.',
            'capitulos.*.capitulo_id.integer' => 'O campo capitulo em capitulos deve ser um número inteiro.',
            'capitulos.*.titulo' => CapituloRequest::messages()['titulo'],

            'titulo.required' => 'O campo titulo é obrigatório.',
            'titulo.string' => 'O campo titulo deve ser um texto.',
            'titulo.min' => 'O campo titulo deve ter texto.',
            'titulo.unique' => 'O titulo fornecido já existe na tabela historia.',
            'subtitulo.required' => 'O campo subtitulo é obrigatório.',
            'subtitulo.string' => 'O campo subtitulo deve ser um texto.',
            'subtitulo.min' => 'O campo subtitulo deve ter texto.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
        ];
    }
}
