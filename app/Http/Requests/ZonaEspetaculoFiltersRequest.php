<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZonaEspetaculoFiltersRequest extends FormRequest
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
            "prova_id" => "nullable|integer|exists:prova,id",
            "nivel_afluencia" => "nullable|string|in:Baixo,Médio,Alto",
            "facilidade_acesso" => "nullable|string|in:Fácil,Médio,Difícil",
            "nivel_ocupacao" => "nullable|string|in:Livre,Intermédio,Completo"
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O campo procurar deve ser um texto.',
            'search.min' => 'O campo procurar deve ter texto.',

            'prova_id.integer' => 'O campo prova deve ser um número inteiro.',
            'prova_id.exists' => 'O campo prova deve existir na tabela provas.',

            'nivel_afluencia.string' => 'O campo nível de afluência deve ser um texto.',
            'nivel_afluencia.in' => 'O campo nível de afluência deve ter um dos seguintes valores: Baixo, Médio, Alto.',

            'facilidade_acesso.string' => 'O campo facilidade de acesso deve ser um texto.',
            'facilidade_acesso.in' => 'O campo facilidade de acesso deve ter um dos seguintes valores: Fácil, Médio, Difícil.',

            'nivel_ocupacao.string' => 'O campo nível de ocupação deve ser um texto.',
            'nivel_ocupacao.in' => 'O campo nível de ocupação deve ter um dos seguintes valores: Livre, Intermédio, Completo.',
        ];
    }

}
