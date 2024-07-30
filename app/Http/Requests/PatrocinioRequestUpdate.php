<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatrocinioRequestUpdate extends FormRequest
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
            "relevancia" => "sometimes | integer | min:1 | max:10",
        ];
    }
    public function messages(): array
    {
        return [
            'relevancia.integer' => 'O campo relevância deve ser um número inteiro.',
            'relevancia.max' => 'O campo relevância não pode ser maior que 10.',
            'relevancia.min' => 'O campo relevância não pode ser menor que 1.',
        ];
    }
}
