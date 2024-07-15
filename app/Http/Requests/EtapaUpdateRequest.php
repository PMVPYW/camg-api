<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtapaUpdateRequest extends FormRequest
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
             "nome" => "sometimes|string|min:0",
             "ano_inicio" => "sometimes|date_format:Y",
             "ano_fim" => "sometimes|nullable|date_format:Y|after:ano_inicio",
        ];
    }
}
