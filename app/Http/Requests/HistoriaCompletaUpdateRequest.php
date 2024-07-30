<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
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
        $etapa_rules = [];
        if (is_array($this->etapas)) {
            foreach ($this->etapas as $index => $etapa) {
                $etapa_id = isset($etapa['id']) ? $etapa['id'] : null;
                if ($etapa_id !== -1) {
                    $etapa_rules["etapas.$index.nome"] = [
                        "sometimes", "string", "min:0",
                        new UniqueUpdateRule("etapa", "nome", $etapa_id)
                    ];
                }else{
                    $etapa_rules["etapas.$index.nome"] = [
                        "required", "string", "min:0",
                    ];
                }
            }
        }

        $capitulo_rules = [];
        if (is_array($this->capitulos)) {
            foreach ($this->capitulos as $index => $capitulo) {
                $capitulo_id = isset($capitulo['id']) ? $capitulo['id'] : null;
                if ($capitulo_id !== -1) {
                    $capitulo_rules["capitulos.$index.titulo"] = [
                        "sometimes", "string", "min:0",
                        new UniqueUpdateRule("capitulo", "titulo", $capitulo_id)
                    ];
                }else{
                    $capitulo_rules["capitulos.$index.titulo"] = [
                        "required", "string", "min:0",
                    ];
                }
            }
        }


        $id_historia = $this->route('historia')->id;
        return array_merge([
            "etapas" => "sometimes|nullable|array",
            'etapas.*' => 'nullable|array',
            'etapas.*.id' => "sometimes|integer",  //serve para identificar o etapa a editar
            'etapas.*.capitulo_id' => "sometimes|integer",
            'etapas.*.ano_inicio' => 'sometimes|integer|digits:4',
            'etapas.*.ano_fim' => 'sometimes|nullable|integer|digits:4|gte:etapas.*.ano_inicio',
            "capitulos" => "sometimes|nullable|array",
            'capitulos.*' => 'nullable|array',
            'capitulos.*.id' => "sometimes|integer", //serve para identificar o capitulo a editar
            'capitulos.*.capitulo_id' => "sometimes|integer",
            "titulo" => ["sometimes", "string", "min:0", new UniqueUpdateRule("historia", "titulo", $id_historia)],
            "subtitulo" => "sometimes|string|min:0",
            "conteudo" => "sometimes|string|nullable",
            "photo_url" => "sometimes|nullable|file|image"
        ], $etapa_rules, $capitulo_rules);
    }

    public function messages(): array
    {
        return [
            'etapas.array' => 'O campo etapas deve ser um array.',
            'etapas.*.array' => 'Cada item em etapas deve ser um vetor.',
            'etapas.*.capitulo_id.integer' => 'O campo capitulo deve ser um número inteiro.',
            'etapas.*.nome.string' => 'O campo nome deve ser um texto.',
            'etapas.*.nome.min' => 'O campo nome deve ter texto.',
            'etapas.*.ano_inicio.required' => 'O campo ano inicio é obrigatório.',
            'etapas.*.ano_inicio.integer' => 'O campo ano inicio deve ser um número inteiro.',
            'etapas.*.ano_inicio.digits' => 'O campo ano inicio deve ter exatamente 4 dígitos.',
            'etapas.*.ano_fim.integer' => 'O campo ano fim deve ser um número inteiro.',
            'etapas.*.ano_fim.digits' => 'O campo ano fim deve ter exatamente 4 dígitos.',
            'etapas.*.ano_fim.gte' => 'O campo ano fim deve ser maior ou igual ao ano inicio.',

            'capitulos.array' => 'O campo capitulos deve ser um vetor.',
            'capitulos.*.array' => 'Cada item em capitulos deve ser um vetor.',
            'capitulos.*.capitulo_id.integer' => 'O campo capitulo em capitulos deve ser um número inteiro.',
            'capitulos.*.titulo.string' => 'O campo título deve ser um texto.',
            'capitulos.*.titulo.min' => 'O campo título deve ter texto.',
            'titulo.string' => 'O campo titulo deve ser um texto.',
            'titulo.min' => 'O campo titulo deve ter texto.',
            'subtitulo.string' => 'O campo subtitulo deve ser um texto.',
            'subtitulo.min' => 'O campo subtitulo deve ter texto.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
        ];
    }
}
