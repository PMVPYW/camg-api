<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivestreamRequest extends FormRequest
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
            "rally_id" => "nullable|integer|exists:rallies,id",
            "nome" => "required|string|unique:livestream,nome",
            "link" => "required|string|url:http,https|unique:livestream,link",
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rally_id.integer' => 'O campo de ID do rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally selecionado não existe.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser uma palavra.',
            'nome.unique' => 'Este nome já existe. Por favor, insira outro.',
            'link.required' => 'O link é obrigatório.',
            'link.string' => 'O link deve ser uma palavra.',
            'link.url' => 'O link deve ser um URL válido começando com http ou https.',
            'link.unique' => 'Este link já está em uso. Por favor, insira outro.',
        ];
    }
}
