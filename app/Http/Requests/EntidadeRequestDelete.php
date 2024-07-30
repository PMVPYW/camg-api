<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadeRequestDelete extends FormRequest
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
            'entidades_id' => 'nullable|array',
            'entidades_id.*' => 'integer|exists:entidades,id',
        ];
    }
    public function messages(): array
    {
        return [
            'entidades_id.array' => 'O campo entidades deve ser um vetor de valores.',
            'entidades_id.*.integer' => 'Cada item do vetor deve ser um número inteiro.',
            'entidades_id.*.exists' => 'Cada item do vetor deve existir na tabela entidades.',
        ];
    }
}
