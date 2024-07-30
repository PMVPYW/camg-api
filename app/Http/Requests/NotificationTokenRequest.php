<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationTokenRequest extends FormRequest
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
            'token' => 'required|string',
            'id_hash' => 'required|string|size:64'
        ];
    }
    public function messages(): array
    {
        return [
            'token.required' => 'O campo token é obrigatório.',
            'token.string' => 'O campo token deve ser um texto.',

            'id_hash.required' => 'O campo hash é obrigatório.',
            'id_hash.string' => 'O campo hash deve ser um texto.',
            'id_hash.size' => 'O campo hash deve ter exatamente 64 caracteres.',
        ];
    }
}
