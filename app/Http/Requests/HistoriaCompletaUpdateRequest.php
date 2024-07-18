<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaCompletaUpdateRequest extends FormRequest
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
            'etapas.*' => 'array',
            'etapas.*.id' => "sometimes|integer",  //serve para identificar o etapa a editar
            'etapas.*.capitulo_id' => "sometimes|integer",
            'etapas.*.nome' => EtapaUpdateRequest::rulesArray()['nome'],
            'etapas.*.ano_inicio' => EtapaUpdateRequest::rulesArray()['ano_inicio'],
            'etapas.*.ano_fim' => EtapaUpdateRequest::rulesArray()['ano_fim'],
            "capitulos" => "sometimes|array",
            'capitulos.*' => 'array',
            'capitulos.*.id' => "sometimes|integer", //serve para identificar o capitulo a editar
            'capitulos.*.capitulo_id' => "sometimes|integer",
            'capitulos.*.titulo' => CapituloUpdateRequest::rulesArray()['titulo'],
            "titulo" => "sometimes|string|min:0|unique:historia,titulo",
            "subtitulo" => "sometimes|string|min:0",
            "conteudo" => "sometimes|string|nullable|",
            "photo_url" => "sometimes|nullable|file|image"
        ];
    }
}
