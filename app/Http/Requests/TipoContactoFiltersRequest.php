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
    public function messages(): array
    {
        return [
            'tipo_contacto_id.integer' => 'O campo tipo de contacto deve ser um número inteiro.',
            'tipo_contacto_id.exists' => 'O campo  tipo de contacto deve existir na tabela tipo de contactos.',
            'order.string' => 'O campo ordem deve ser um texto.',
            'order.in' => 'O campo order ordem ser um dos seguintes valores: nome_asc, nome_desc.',
        ];
    }
}
