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
            "select" => "nullable|string|in:outro,presidente,piloto,copiloto",
            "search_outro" => "nullable|string|min:0",
        ];
    }
}
