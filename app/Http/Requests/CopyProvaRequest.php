<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CopyProvaRequest extends FormRequest
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
            "external_entity_id" => "required|integer|exists:rallies,external_entity_id",
            "rally_id" => "required|integer|exists:rallies,id",
        ];
    }
    public function messages():array
    {
        return [
            'external_entity_id.required' => 'O campo ID da entidade externa é obrigatório.',
            'external_entity_id.integer' => 'O campo ID da entidade externa deve ser um número inteiro.',
            'external_entity_id.exists' => 'O ID da entidade externa fornecido não existe na tabela rallies.',
            'rally_id.required' => 'O campo rally é obrigatório.',
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe na tabela rallies.',
        ];
    }

}
