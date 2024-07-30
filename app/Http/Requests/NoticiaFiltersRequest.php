<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaFiltersRequest extends FormRequest
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
            "search" => "nullable|string|min:0",
            "data_inicio" => "nullable|date",
            "data_fim" => "nullable|date",
            "rally_id" => "nullable|integer|exists:rallies,id",
            "order" => "nullable|string|in:date_desc,date_asc,titulo_asc,titulo_desc"
        ];
    }
    public function messages()
    {
        return [
            'search.string' => 'O campo pesquisa deve ser um texto.',
            'search.min' => 'O campo pesquisa deve ter texto.',
            'data_inicio.date' => 'O campo data início deve ser uma data válida.',
            'data_fim.date' => 'O campo data fim deve ser uma data válida.',
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe na tabela rallies.',
            'order.string' => 'O campo ordem deve ser um texto.',
            'order.in' => 'O campo ordem deve ter um dos seguintes valores: date_desc, date_asc, titulo_asc, titulo_desc.',
        ];
    }
}
