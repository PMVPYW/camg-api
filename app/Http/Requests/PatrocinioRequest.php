<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatrocinioRequest extends FormRequest
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
            "rally_id" => "required | integer |exists:rallies,id",
            "entidade_id" => "required | integer |exists:entidades,id",
            "relevancia" => "required | integer | min:1 | max:10",
            "entidade_oficial" => "required | boolean"
        ];
    }
    public function messages(): array
    {
        return [
            'rally_id.required' => 'O campo rally_id é obrigatório.',
            'rally_id.integer' => 'O campo rally_id deve ser um número inteiro.',
            'rally_id.exists' => 'O rally_id fornecido não existe na tabela rallies.',
            'entidade_id.required' => 'O campo entidade_id é obrigatório.',
            'entidade_id.integer' => 'O campo entidade_id deve ser um número inteiro.',
            'entidade_id.exists' => 'O entidade_id fornecido não existe na tabela entidades.',
            'relevancia.required' => 'O campo relevancia é obrigatório.',
            'relevancia.integer' => 'O campo relevancia deve ser um número inteiro.',
            'relevancia.max' => 'O campo relevancia não pode ser maior que 10.',
            'relevancia.min' => 'O campo relevancia não pode ser menor que 1.',
            'entidade_oficial.required' => 'O campo entidade_oficial é obrigatório.',
            'entidade_oficial.boolean' => 'O campo entidade_oficial deve ser verdadeiro ou falso.',
        ];
    }
}
