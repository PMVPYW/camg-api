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
            "etapas" => "sometimes|array",
            'etapas.*' => 'sometimes|array',
            'etapas.*.id' => "sometimes|integer",  //serve para identificar o etapa a editar
            'etapas.*.capitulo_id' => "sometimes|integer",
            'etapas.*.ano_inicio' => 'sometimes|integer|digits:4|lte:etapas.*.ano_fim',
            'etapas.*.ano_fim' => 'sometimes|nullable|integer|digits:4|gte:etapas.*.ano_inicio',
            "capitulos" => "sometimes|array",
            'capitulos.*' => 'sometimes|array',
            'capitulos.*.id' => "sometimes|integer", //serve para identificar o capitulo a editar
            'capitulos.*.capitulo_id' => "sometimes|integer",
            "titulo" => ["sometimes", "string", "min:0", new UniqueUpdateRule("historia", "titulo", $id_historia)],
            "subtitulo" => "sometimes|string|min:0",
            "conteudo" => "sometimes|string|nullable",
            "photo_url" => "sometimes|nullable|file|image"
        ], $etapa_rules, $capitulo_rules);
    }
}
