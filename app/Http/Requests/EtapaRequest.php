<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtapaRequest extends FormRequest
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
            "capitulo_id" => "integer|sometimes|nullable|exists:capitulo,id",
            "nome" => "required|string|min:0",
            "ano_inicio" => "required|integer|digits:4",
            "ano_fim" => "sometimes|nullable|integer|digits:4|gte:ano_inicio",
        ];
    }

    public static function rulesArray(): array
    {
        return [
            "nome" => "required|string|min:0",
        ];
    }

    public function messages(): array
    {
        return [
            'capitulo_id.integer' => 'O campo capitulo deve ser um número inteiro.',
            'capitulo_id.exists' => 'O capitulo fornecido não existe na tabela capitulo.',

            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.min' => 'O campo nome deve ter texto.', // Note que a regra `min:0` não faz sentido, mas adicionei para mostrar um exemplo.

            'ano_inicio.required' => 'O campo ano inicio é obrigatório.',
            'ano_inicio.integer' => 'O campo ano inicio deve ser um número inteiro.',
            'ano_inicio.digits' => 'O campo ano inicio deve ter exatamente 4 dígitos.',

            'ano_fim.integer' => 'O campo ano fim deve ser um número inteiro.',
            'ano_fim.digits' => 'O campo ano fim deve ter exatamente 4 dígitos.',
            'ano_fim.gte' => 'O campo ano fim deve ser maior ou igual ao ano inicio.',
        ];
    }
}
