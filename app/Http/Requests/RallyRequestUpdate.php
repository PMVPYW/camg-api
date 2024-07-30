<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RallyRequestUpdate extends FormRequest
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
            "nome" => "sometimes|string|min:0",
            "data_inicio" => "sometimes|date|before_or_equal:data_fim",
            "data_fim" => "sometimes|date|after_or_equal:data_inicio",
            "external_entity_id" => "sometimes|integer",
            "photo_url" => "file|image"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.min' => 'O campo nome deve ter texto.',
            'data_inicio.date' => 'O campo data_inicio deve ser uma data válida.',
            'data_inicio.before_or_equal' => 'A data de início deve ser anterior ou igual à data de fim.',
            'data_fim.date' => 'O campo data_fim deve ser uma data válida.',
            'data_fim.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início.',
            'external_entity_id.integer' => 'O campo ID da entidade externa deve ser um número inteiro.',
            'photo_url.file' => 'O campo foto deve ser um arquivo.',
            'photo_url.image' => 'O campo foto deve ser uma imagem.',
        ];
    }
}
