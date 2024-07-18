<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeclaracaoUpdateRequest extends FormRequest
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
            "nome" => "sometimes|string",
            "photo_url" => 'sometimes|file|image',
            "conteudo" => "sometimes|string",
            "rally_id" => "sometimes|integer|exists:rallies,id",
            "cargo" => "sometimes|string",
            "entidade_equipa"=>"sometimes|nullable|string",
            "pontos"=>"sometimes|nullable|integer"
        ];
    }
}
