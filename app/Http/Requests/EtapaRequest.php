<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtapaRequest extends FormRequest
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
            "capitulo_id" => "integer|sometimes|nullable|exists:capitulo,id",
            "nome" => "required|string|min:0",
            "ano_inicio" => "required|integer|digits:4",
            "ano_fim" => "sometimes|nullable|integer|digits:4|gte:ano_inicio",
        ];
    }

    public static function rulesArray(): array
    {
        return [
            "nome" => "required|string|min:0",
        ];
    }
}
