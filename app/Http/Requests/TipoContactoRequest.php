<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoContactoRequest extends FormRequest
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
            "nome" => "required|string|unique"
        ];
    }
    public function messages()
    {
        return [
            "nome.required" => "O campo nome é obrigatório.",
            "nome.string" => "O campo nome deve ser uma string.",
            "nome.unique" => "Este nome já está em uso."
        ];
    }
}
