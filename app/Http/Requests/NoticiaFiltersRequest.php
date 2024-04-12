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
}
