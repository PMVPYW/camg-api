<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapituloRequest extends FormRequest
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
            "historia_id" => "integer|sometimes|nullable|exists:historia,id",
            "titulo" => "required|string|min:0|unique:capitulo,titulo",
        ];
    }
    public static function rulesArray(): array
    {
        return [
            "titulo" => "required|string|min:0|unique:capitulo,titulo",
        ];
    }

    public function messages(): array
    {
        return [
            'historia_id.integer' => 'O campo historia deve ser um número inteiro.',
            'historia_id.exists' => 'A história fornecida não existe.',
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.min' => 'O campo título deve ter texto.',
            'titulo.unique' => 'O título fornecido já está em uso.',
        ];
    }

}
