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
}
