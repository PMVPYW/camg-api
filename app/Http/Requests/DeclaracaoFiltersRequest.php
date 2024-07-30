<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeclaracaoFiltersRequest extends FormRequest
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
            "order" => "nullable|string|in:cargo_desc,cargo_asc,nome_asc,nome_desc",
            "select" => "nullable|string|in:outro,presidente,piloto,copiloto,todos",
            "search_outro" => "nullable|string|min:0",
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O campo procurar deve ser um texto.',
            'search.min' => 'O campo procurar deve ter texto.',
            'order.string' => 'O campo ordem deve ser um texto.',
            'order.in' => 'O valor do campo ordem deve ser um dos seguintes: cargo_desc, cargo_asc, nome_asc, nome_desc.',
            'select.string' => 'O campo seleção deve ser um texto.',
            'select.in' => 'O valor do campo seleção deve ser um dos seguintes: outro, presidente, piloto, copiloto, todos.',
            'search_outro.string' => 'O campo procurar outro deve ser um texto.',
            'search_outro.min' => 'O campo procurar outro deve ser um texto.',
        ];
    }
}
