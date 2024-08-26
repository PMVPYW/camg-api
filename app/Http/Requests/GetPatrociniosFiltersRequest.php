<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPatrociniosFiltersRequest extends FormRequest
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
            "filters" => "nullable|string|in:nome_asc,nome_desc,rel_asc,rel_desc"
        ];
    }
    public function messages(): array
    {
        return [
            'filters.string' => 'O campo filtros deve ser um texto.',
            'filters.in' => 'O campo filtros deve ter um dos seguintes valores: nome_asc, nome_desc, rel_asc, rel_desc.',
        ];
    }
}
