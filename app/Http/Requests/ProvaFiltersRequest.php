<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvaFiltersRequest extends FormRequest
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
            "rally_id" => "nullable|integer|exists:rallies,id",
            "order" => "nullable|string|in:nome_desc,nome_asc,local_asc,local_desc,distancia_percurso_asc,distancia_percurso_desc,proximity"
        ];
    }
}
