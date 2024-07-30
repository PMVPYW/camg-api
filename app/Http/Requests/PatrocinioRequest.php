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
            'rally_id.required' => 'O campo rally é obrigatório.',
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe na tabela rallies.',
            'entidade_id.required' => 'O campo entidade é obrigatório.',
            'entidade_id.integer' => 'O campo entidade deve ser um número inteiro.',
            'entidade_id.exists' => 'A entidade fornecida não existe na tabela entidades.',
            'relevancia.required' => 'O campo relevância é obrigatório.',
            'relevancia.integer' => 'O campo relevância deve ser um número inteiro.',
            'relevancia.max' => 'O campo relevância não pode ser maior que 10.',
            'relevancia.min' => 'O campo relevância não pode ser menor que 1.',
            'entidade_oficial.required' => 'O campo entidade oficial é obrigatório.',
            'entidade_oficial.boolean' => 'O campo entidade oficial deve ser verdadeiro ou falso.',
        ];
    }
}
