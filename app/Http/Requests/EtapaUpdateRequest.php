<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class EtapaUpdateRequest extends FormRequest
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
         $id = $this->route('etapa')->id;
         return [
             "capitulo_id" => "integer|sometimes|nullable|exists:capitulo,id",
             "nome" => ["sometimes","string","min:0",new UniqueUpdateRule("etapa", "nome", $id)],
             "ano_inicio" => "sometimes|integer|digits:4",
             "ano_fim" => "sometimes|nullable|integer|digits:4|gte:ano_inicio",
        ];
    }
    public function messages(): array
    {
        return [
            'capitulo_id.integer' => 'O campo capitulo deve ser um número inteiro.',
            'capitulo_id.exists' => 'O capitulo fornecido não existe na tabela capitulo.',

            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.min' => 'O campo nome deve ter texto.',

            'ano_inicio.integer' => 'O campo ano inicio deve ser um número inteiro.',
            'ano_inicio.digits' => 'O campo ano inicio deve ter exatamente 4 dígitos.',

            'ano_fim.integer' => 'O campo ano fim deve ser um número inteiro.',
            'ano_fim.digits' => 'O campo ano fim deve ter exatamente 4 dígitos.',
            'ano_fim.gte' => 'O campo ano fim deve ser maior ou igual ao ano inicio.',
        ];
    }


    public static function rulesArray(): array
    {
        return [
            "nome" => "sometimes|string|min:0",
        ];
    }
}
