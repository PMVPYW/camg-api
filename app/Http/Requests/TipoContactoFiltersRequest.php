<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoContactoFiltersRequest extends FormRequest
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
            "tipo_contacto_id" => "nullable|integer|exists:tipo_contacto,id",
            "order" => "nullable|string|in:nome_asc,nome_desc"
        ];
    }
}
