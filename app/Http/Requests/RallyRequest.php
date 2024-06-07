<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RallyRequest extends FormRequest
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
            "nome" => "required|string|min:0|unique:rallies,nome",
            "data_inicio" => "required|date|before_or_equal:data_fim",
            "data_fim" => "required|date|after_or_equal:data_inicio",
            "external_entity_id" => "required|integer",
            "photo_url" => "file|image"
        ];
    }

    public function messages()
    {
        return [
            "nome.required" => "O campo nome é obrigatório.",
            "nome.string" => "O campo nome deve ser uma string.",
            "nome.min" => "O campo nome deve ter pelo menos :min caracteres.",
            "nome.unique" => "Este nome já está em uso.",
            "data_inicio.required" => "O campo data de início é obrigatório.",
            "data_inicio.date" => "O campo data de início deve ser uma data válida.",
            "data_inicio.before_or_equal" => "A data de início deve ser anterior ou igual à data de fim.",
            "data_fim.required" => "O campo data de fim é obrigatório.",
            "data_fim.date" => "O campo data de fim deve ser uma data válida.",
            "data_fim.after_or_equal" => "A data de fim deve ser posterior ou igual à data de início.",
            "external_entity_id.required" => "O campo ID da entidade externa é obrigatório.",
            "external_entity_id.integer" => "O campo ID da entidade externa deve ser um número inteiro.",
            "photo_url.file" => "O campo foto deve ser um ficheiro.",
            "photo_url.image" => "O campo foto deve ser uma imagem."
        ];

    }
}
