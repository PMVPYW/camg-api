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
            'etapas.*.ano_inicio' => 'required|integer|min:1000|max:9999|lte:etapas.*.ano_fim',
            'etapas.*.ano_fim' => 'sometimes|nullable|integer|min:1000|max:9999|gte:etapas.*.ano_inicio',
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
}
