<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class LivestreamUpdateRequest extends FormRequest
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
        $resourceId = $this->route('livestream')->id;
        return [
            "rally_id" => "nullable|integer|exists:rallies,id",
            "nome" => ["sometimes","string", new UniqueUpdateRule("livestream", "nome", $resourceId)],
            "visivel" => "sometimes|boolean",
            "link" => ["sometimes","string","url:http,https", new UniqueUpdateRule("livestream", "link", $resourceId)],
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
            'nome.string' => 'O nome deve ser uma palavra.',
            'nome.unique_update_rule' => 'Este nome já existe. Por favor, insira outro.',
            'visivel.boolean' => 'O campo visível deve ser verdadeiro ou falso.',
            'link.string' => 'O link deve ser uma cadeia de caracteres.',
            'link.url' => 'O link deve ser um URL válido começando com http ou https.',
            'link.unique_update_rule' => 'Este link já existe. Por favor, insira outro.',
        ];
    }
}
